@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row" id="VueApp">
        <div class="erp-employee-list-wrapper">
            <div class="new-production-wrapper bg-card attd-table">
                <form action="{{route('production.pre-production.update', $pre_production->id)}}" id="preProductionStoreForm" method="POST" @submit="checkValidation">
                    @csrf
                    <div class="product-general-info-box d-flex flex-wrap">
                        <div class="pgib-item flex-35">
                            <div class="input-block erp-step-input-block mb-0">
                                <label class="col-form-label">Batch No <span class="text-red">*</span></label>
                                <input class="form-control" value="{{$pre_production->pre_production_batch_no}}" name="pre_production_batch_no" type="text" placeholder="" required="">
                            </div>
                        </div>
                        <div class="pgib-item flex-35">
                            <div class="input-block erp-step-input-block mb-0">
                                <label class="col-form-label">Date <span class="text-red">*</span></label>
                                <input class="form-control datetimepicker" value="{{$pre_production->date?? \Carbon\Carbon::now()->format('Y-m-d') }}" name="date" type="text" placeholder="" required="">
                            </div>
                        </div>
                        <div class="pgib-item flex-25">
                            <div class="input-block erp-step-input-block mb-0">
                                <label class="col-form-label">Image</label>
                                <input class="form-control" name="image" type="file" placeholder="">
                            </div>
                        </div>
                        <div class="pgib-item flex-35">
                            <div class="input-block erp-step-input-block mb-0">
                                <label class="col-form-label">Order Details <span class="text-red">*</span></label>
                                <input value="{{$pre_production->order_details}}" class="form-control" name="order_details" type="text" placeholder="" required="">
                            </div>
                        </div>
                        <div class="pgib-item flex-36">
                            <div class="input-block erp-step-input-block mb-0">
                                <label class="col-form-label">Design Of Documents</label>
                                <input class="form-control" name="design_of_documents" type="file" multiple>
                            </div>
                        </div>
                        <div class="pgib-item flex-100">
                            <div class="input-block erp-step-input-block mb-0">
                                <label class="col-form-label">Description</label>
                                <textarea rows="2" name="description" class="form-control">{{$pre_production->description}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="product-selection-info-box d-flex flex-wrap">
                        <div class="psib-item flex-68">
                            <div class="input-block erp-step-input-block mb-0 two">
                                <label class="col-form-label">Product<small>(Finished Product)</small> Selection <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Product Select"><i class="fa-duotone fa-exclamation"></i></span></label>
                                <select class="select select-step" name="finished_goods_id" required="">
                                    <option value="">Select Product</option>
                                    @foreach ($finished_products as $f_product)
                                        <option value="{{$f_product->id}}" {{$pre_production->finished_goods_id == $f_product->id? 'selected' : ''}}>{{$f_product->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="psib-item flex-30">
                            <div class="input-block erp-step-input-block mb-0">
                                <label class="col-form-label">Estimated Output QTY <span class="text-red">*</span></label>
                                <input class="form-control" value="{{$pre_production->estimated_production_qty}}" name="estimated_production_qty" type="number" min="0" placeholder="" required="">
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="production-process-wrapper process-wrapper" v-for="(process, index) in processes" :key="index">
                            <input type="hidden" name="pre_production_process_id[]" :value="process.process_id">
                            <div class="production-process-status-wrapper">
                                {{-- <h4>Process @{{ index + 1 }}</h4> --}}
                                <div class="production-machine-selection-wrapper d-flex flex-wrap">
                                    <div class="pms-item flex-48">
                                        <h4>Process @{{ index + 1 }}</h4>
                                    </div>
                                    <div class="pms-item flex-48 ">
                                        <div class="input-block erp-step-input-block mb-0 d-flex">
                                            <label class="col-form-label prod-p-staff">Production Staff <span class="text-danger">*</span></label>
                                            <select class="select select-step select2" name="production_staff_id[]" required>
                                                <option value="">Select Production Staff</option>
                                                <option v-for="staff in staffs"  :value="staff.id" :key="staff.id" :selected="staff.id == process.process_production_staff_id">@{{staff.user_name}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="production-machine-selection-wrapper d-flex flex-wrap">
                                <div class="pms-item flex-48">
                                    <div class="input-block erp-step-input-block mb-0">
                                        <label class="col-form-label">Machine Selection <span class="text-danger">*</span></label>
                                        <select class="machine-multiselect" :name="'machine_id['+index+'][]'" multiple="multiple" required>
                                            <option v-for="machine in machines"  :value="machine.id" :key="machine.id" :selected="process.process_machine_ids?.includes(machine.id)">@{{machine.name}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="pms-item flex-48" v-if="index > 0">
                                    <div class="input-block erp-step-input-block mb-0">
                                        <label class="col-form-label">Previous Process </label>
                                        <select class="process-multiselect" :name="'previous_process['+index+'][]'" multiple="multiple">
                                            <option v-for="(innerProcess, idx) in processes.slice(0, index)" :selected="processSelectedIndexes(process).includes(idx)" :value="idx" :key="idx">Process @{{ idx + 1 }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="production-matarial-selection-wrapper">
                                <h4 class="process-child-title">Material</h4>
                                <div class="pms-item-main-wrapper" v-if="process.materialSections.length > 0">
                                    <div class="pms-item-wrapper d-flex flex-wrap align-items-end" v-for="(materialSection, materialIndex) in process.materialSections" :key="materialIndex">
                                        <input type="hidden" :name="'process_material_id['+index+'][]'" :value="materialSection.id"/>
                                        <input type="hidden" :name="'material_type['+index+'][]'" :value='materialSection.type'>
                                        
                                        <div class="pms-item flex-32" v-if="materialSection.type == 'other'">
                                            <div class="input-block erp-step-input-block mb-0">
                                                <label class="col-form-label">Material Category </label>
                                                <select class="select select-step" :name="'product_material_category_id['+index+'][]'" :data-index="index" :data-material-index="materialIndex" onchange="categoryChangeOutside(this)">
                                                    <option value="">Select Category</option>
                                                    <option v-for="category in categories"  :value="category.id" :key="category.id" :selected="category.id == materialSection.product_material_category_id">@{{category.name}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="pms-item flex-32" v-if="materialSection.type == 'board'">
                                            <div class="input-block erp-step-input-block mb-0">
                                                <label class="col-form-label">Board Category </label>
                                                <select class="select select-step" :name="'product_material_category_id['+index+'][]'" :data-index="index" :data-material-index="materialIndex" onchange="boardCategoryChangeOutside(this)">
                                                    <option value="">Select Category</option>
                                                    <option v-for="category in board_categories"  :value="category.id" :key="category.id" :selected="category.id == materialSection.product_material_category_id">@{{category.name}}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="pms-item flex-32" v-if="materialSection.type == 'other'">
                                            <div class="input-block erp-step-input-block mb-0">
                                                <label class="col-form-label">Material </label>
                                                <select :name="'product_material_id['+index+'][]'" class="select select-step material-product" v-if="processes && processes.length > 0">
                                                    <option value="">Select Material</option>
                                                    <option v-for="product in processes[index].materialSections[materialIndex].products"
                                                        :selected="product.id == materialSection.product_material_id" :key="product.id" :value="product.id">
                                                        @{{ product.name }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="pms-item flex-32" v-if="materialSection.type == 'board'">
                                            <div class="input-block erp-step-input-block mb-0">
                                                <label class="col-form-label">Finished Board </label>
                                                <select :name="'product_material_id['+index+'][]'" class="select select-step material-product" v-if="processes && processes.length > 0">
                                                    <option value="">Select Board</option>
                                                    <option v-for="product in processes[index].materialSections[materialIndex].products"
                                                        :selected="product.id == materialSection.product_material_id" :key="product.id" :value="product.id">
                                                        @{{ product.name }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="pms-item flex-15">
                                            <div class="input-block erp-step-input-block mb-0">
                                                <label class="col-form-label">QTY </label>
                                                <input v-model="materialSection.quantity" :name="'quantity['+index+'][]'" class="form-control " type="number" min="0" placeholder="" >
                                            </div>
                                        </div>
                                        <div class="pms-item flex-10">
                                            <div class="add-more-m-box d-flex justify-content-center gap-2 align-items-center">
                                                {{-- <a href="#" class="add-more-m-btn" @click.prevent="addMaterialSection(index)"><i class="la la-plus-circle"></i></a> --}}
                                                <a v-if="materialIndex > 0" @click.prevent="removeMaterialSection(index,materialIndex)" href="#" class="add-more-m-btn remove-item"><i class="la la-times-circle"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="pms-item flex-100">
                                        <div class="add-more-m-box d-flex justify-content-center gap-2 align-items-center">
                                            <a href="#" class="erp-search-btn text-center pp-add-more-btn" @click.prevent="addMaterialOtherSection(index)"><i class="la la-plus-circle"></i> Other</a>
                                            <a href="#" @click.prevent="addMaterialBoardSection(index)" class="erp-search-btn text-center pp-add-more-btn pp-add-board-btn"><i class="la la-plus-circle"></i> Board</a>
                                        </div>
                                    </div>
                                </div>
                                <div v-else class="pms-item-main-wrapper d-flex justify-content-center"> 
                                    <a href="#" class="add-more-m-btn" @click.prevent="addMaterialSection(index)"><i class="la la-plus-circle"></i></a>
                                </div>
                            </div>
                            
                            <div class="production-estimate-output-selection-wrapper">
                                <h4 class="process-child-title">Estimated Output</h4>
                                <div class="pms-item-main-wrapper">
                                    <div class="pms-item-wrapper d-flex flex-wrap align-items-end" v-for="(estimatedSection, estimatedIndex) in process.estimatedOutputs" :key="estimatedIndex">
                                        <input type="hidden" :name="'process_output_id['+index+'][]'" :value="estimatedSection.id"/>
                                        <div class="pms-item flex-60">
                                            <div class="input-block erp-step-input-block mb-0">
                                                <label class="col-form-label">Name <span class="text-danger">*</span></label>
                                                <input class="form-control" v-model="estimatedSection.name" :name="'name['+index+'][]'" type="text" placeholder="" required="">
                                            </div>
                                        </div>
                                        
                                        <div class="pms-item flex-15">
                                            <div class="input-block erp-step-input-block mb-0">
                                                <label class="col-form-label">QTY <span class="text-danger">*</span></label>
                                                <input class="form-control" v-model="estimatedSection.quantity" :name="'output_quantity['+index+'][]'" type="number" min="0" placeholder="" required="">
                                            </div>
                                        </div>
                                        <div class="pms-item flex-10">
                                            <div class="add-more-m-box d-flex justify-content-center gap-2 align-items-center">
                                                <a href="#" @click.prevent="addEstimatedOutputSection(index)" class="add-more-m-btn"><i class="la la-plus-circle"></i></a>
                                                <a href="#" v-if="estimatedIndex > 0" @click.prevent="removeEstimatedOutputSection(index,estimatedIndex)" class="add-more-m-btn remove-item"><i class="la la-times-circle"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                
                                </div>
                            </div>
                            <div class="production-instrucion-output-selection-wrapper">
                                <div class="input-block erp-step-input-block mb-0">
                                    <label class="col-form-label">Instruction</label>
                                    <textarea rows="1" v-model="process.process_instruction"  name="instruction[]" class="form-control"></textarea>
                                </div>	
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <div class="text-center">
                            <button class="add-section-wh-btn text-center" type="button" @click="addProcessHandler()">Add Process</button>
                        </div>
                        <div class="text-center ms-1" v-if="processes.length > 1">
                            <button class="remove-process-btn text-center" type="button" @click="removeLastProcess()">Remove Last Process</button>
                        </div>
                    </div>
                    <div class="production-instrucion-output-selection-wrapper mt-5 ms-3">
                        <div class="input-block erp-step-input-block mb-0">
                            <label class="col-form-label">Note</label>
                            <textarea rows="3" class="form-control" name="notes">{{$pre_production->notes}}</textarea>
                        </div>	
                    </div>
                    <div class="production-instrucion-output-selection-wrapper mt-3 p-2 text-center">
                        <button class=" erp-search-btn text-center">Update Production</button>
                    </div>
                <form>
            </div>
        
        </div>
        

    </div>
    <!--End::row-1 -->
@endsection

@section('modals')
    
@endsection

@section('css')
    <style>
        .remove-process-btn{
            margin-top: 0;
            border-radius: 0px 0px 50px 50px;
            padding: 5px 30px;
            border: 2px dashed rgb(233 49 49);
            background-color: #ffe3e3;
            border-top: none;
            font-size: 12px;
            font-weight: 700;
            font-weight: 800;
        }
        .prod-p-staff{
            width: 48%;
        }
    </style>
@endsection

@section('css_plugins')
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap-datetimepicker.min.css')}}">
@endsection

@section('js_plugins')
    <script src="{{asset('assets')}}/plugins/multipleselect/multiple-select.js"></script>
    <script src="{{asset('assets')}}/plugins/multipleselect/multi-select.js"></script> 
    <script src="{{asset('assets/js/moment.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap-datetimepicker.min.js')}}"></script>

    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
@endsection

@section('js')
    <script>
        var { createApp } = Vue;
        var vueApp = createApp({
            data() {
                return {
                    processes: [],
                    categories: [],
                    board_categories: [],
                    machines: [],
                    staffs: [],
                    process_indexes: [],
                };
            },
            computed: {

            },
            methods: {
                getProcesses(initialLoad = false) {
                    var currentUrl = window.location.href;
                    var id = currentUrl.split('/').slice(-2, -1)[0];
                    let url = "{{route('production.pre-production.get-all-processes', ':id')}}";
                    url = url.replace(':id', id);
                    axios
                    .get(url)
                        .then(response => {
                            const processes = response.data.processes;
                            const categories = response.data.categories;
                            const board_categories = response.data.finished_categoris;
                            const machines = response.data.machines;
                            const staffs = response.data.staffs;
                            this.process_indexes = response.data.process_indexes;

                            categories.forEach((category) => {
                                this.categories.push({
                                    ...category
                                });
                            });

                            board_categories.forEach((board_category) => {
                                this.board_categories.push({
                                    ...board_category
                                });
                            });

                            machines.forEach((machine) => {
                                this.machines.push({
                                    ...machine
                                });
                            });

                            staffs.forEach((staff) => {
                                this.staffs.push({
                                    ...staff
                                });
                            });
                            processes.forEach((process) => {
                                const materials = process.materials.map(material => {
                                    return {
                                        id: material.id,
                                        type: 'other',
                                        pre_production_process_id: material.pre_production_process_id,
                                        product_material_category_id: material.product_material_category_id,
                                        product_material_id: material.product_material_id,
                                        quantity: material.quantity
                                    };
                                });

                                const estimated_output = process.estimated_output.map( output => {
                                    return {
                                        id: output.id,
                                        name: output.name,
                                        quantity: output.quantity,
                                    };
                                });
                                
                                const process_machine_ids = process.process_machines.map(machine => machine.machine_id);

                                const previous_process_ids = process.previous_process.map(pp => pp.process_id);

                                const newProcess = {
                                    index: processes.length,
                                    process_id: process.id,
                                    process_instruction: process.instruction,
                                    process_production_staff_id: process.production_staff_id,
                                    materialSections: materials,
                                    estimatedOutputs: estimated_output,
                                    process_machine_ids: process_machine_ids,
                                    previous_process_ids: previous_process_ids
                                };

                                if (process.board_materials.length > 0) {
                                    process.board_materials.forEach(board => {
                                        newProcess.materialSections.push({
                                            id: board.id,
                                            type: 'board',
                                            pre_production_process_id: board.pre_production_process_id,
                                            product_material_category_id: board.finished_board_category_id,
                                            product_material_id: board.finished_board_id,
                                            quantity: board.quantity
                                        });
                                    });
                                }

                                this.processes.push(newProcess);
                            });

                            if(initialLoad === true) {
                                this.processes.forEach((process, processIndex) => {
                                    process.materialSections.forEach((materialSection, materialIndex) => {
                                        const categoryId = materialSection.product_material_category_id;
                                        const type = materialSection.type;
                                        if (categoryId) {
                                            if(type == 'other'){
                                                this.getMaterialProducts(categoryId, processIndex, materialIndex);
                                            }else if (type == 'board'){
                                                this.getBoardProducts(categoryId, processIndex, materialIndex);
                                            }
                                        }
                                    });
                                });

                                initMaterialProductMultipleSelect();
                                initAssteProductMultipleSelect(); 
                                initSelect2(); 
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching processes:', error);
                        });
                },

                addProcessHandler(){
                    const newIndex = this.processes.length + 1;
                    this.processes.push({
                        index: newIndex,
                        materialSections: [{
                            type: 'other',
                            products: []
                        }],
                        estimatedOutputs: [{}]
                    });
                    this.$nextTick(() => {
                        initMaterialProductMultipleSelect();
                        initAssteProductMultipleSelect();
                        initSelect2();
                    });
                },

                removeLastProcess() {
                    if (this.processes.length > 1) {
                        this.processes.pop();
                    }
                },

                addMaterialOtherSection(processIndex){
                    this.processes[processIndex].materialSections.push({
                        type: 'other'
                    });
                    this.$nextTick(() => {
                        initSelect2();
                    });
                },

                addMaterialBoardSection(processIndex){
                    this.processes[processIndex].materialSections.push({
                        type: 'board'
                    });
                    this.$nextTick(() => {
                        initSelect2();
                    });
                },

                removeMaterialSection(processIndex, materialIndex) {
                    this.processes[processIndex].materialSections.splice(materialIndex, 1);
                    this.$nextTick(() => {
                        initSelect2();
                    });
                },

                addEstimatedOutputSection(processIndex){
                    this.processes[processIndex].estimatedOutputs.push({});

                    this.$nextTick(() => {
                        initSelect2();
                    });
                },

                removeEstimatedOutputSection(processIndex, estimatedIndex) {
                    this.processes[processIndex].estimatedOutputs.splice(estimatedIndex, 1);
                },

                getMaterialProducts(categoryId, processIndex, materialIndex) {
                    let url = "{{ route('production.pre-production.get-material-products', ':id') }}";
                    url = url.replace(':id', categoryId);
                    axios.get(url)
                        .then(response => {
                            const products = response.data.products;
                            vueApp.processes[processIndex].materialSections[materialIndex].products = products;
                        })
                        .catch(error => {
                            console.error('Error fetching products:', error);
                        });
                },

                getBoardProducts(categoryId, processIndex, materialIndex){
                    let url = "{{ route('production.pre-production.get-board-products', ':id') }}";
                    url = url.replace(':id', categoryId);
                    axios.get(url)
                        .then(response => {
                            const products = response.data.products;
                            vueApp.processes[processIndex].materialSections[materialIndex].products = products;
                        })
                        .catch(error => {
                            console.error('Error fetching products:', error);
                        });

                },

                checkValidation(e) {
                    e.preventDefault();
                    let allInputsFilled = true;
                    $('.erp-step-input-block input[required]').each(function() {
                        if ($(this).val() === '') {
                            allInputsFilled = false;
                            return false;
                        }
                    });

                    if (!allInputsFilled) {
                        showErrorAlert('Opps!', 'Please fill in all inputs!');
                    } else {
                        preProductionFormSubmit();
                    }
                },
                processSelectedIndexes(process) {
                    let process_ids = this.process_indexes;
                    let previous_process_ids = process.previous_process_ids;
                    let indexes = [];

                    previous_process_ids?.forEach(id => {
                        if (id in process_ids) {
                            indexes.push(process_ids[id]);
                        }
                    });
                    return indexes;
                }
            },
            mounted () {
                this.getProcesses(true);
                this.$nextTick(() => {
                    setTimeout(function() {
                        initMaterialProductMultipleSelect();
                        initAssteProductMultipleSelect(); 
                        initSelect2(); 
                    }, 100);
                    
                });
            }


        }).mount('#VueApp');


        // other functions

        $(document).ready(function () {
            initializeDatepicker();
        });

        function initializeDatepicker() {
            $('.datetimepicker').datetimepicker({
                format: 'YYYY-MM-DD',
                icons: {
                    up: "fa fa-angle-up",
                    down: "fa-solid fa-angle-down",
                    next: 'fa-solid fa-angle-right',
                    previous: 'fa-solid fa-angle-left'
                }
            });
        }

        function initSelect2() {
            $('.select-step').select2({
                minimumResultsForSearch: -1,
                width: '100%',
            });
        }
        function initAssteProductMultipleSelect(){
            $('.machine-multiselect').multipleSelect('destroy');
            $('.machine-multiselect').multipleSelect({
                filter: true,
                placeholder: 'Select Machine',
                minimumCountSelected: 6,
                filterPlaceholder: 'Search Machine',
                selectAll: true,
                onOpen: function () {
                    $(".machine-multiselect .ms-drop ul>li:first-child label").contents().filter(function() {
                        return this.nodeType === 3;
                    }).replaceWith("Select All Machines");
                },
            });
        }

        function initMaterialProductMultipleSelect(){
            $('.process-multiselect').multipleSelect({
                filter: true,
                placeholder: 'Select Process',
                minimumCountSelected: 6,
                filterPlaceholder: 'Search Process',
                selectAll: true,
                onOpen: function () {
                    $(".process-multiselect .ms-drop ul>li:first-child label").contents().filter(function() {
                        return this.nodeType === 3;
                    }).replaceWith("Select All Process");
                },
            });
        }
        function categoryChangeOutside(select) {
            const index = select.dataset.index;
            const materialIndex = select.dataset.materialIndex;
            let cat = $(select).val();
            vueApp.getMaterialProducts(cat, index, materialIndex);
        }

        function boardCategoryChangeOutside(select){
            const index = select.dataset.index;
            const materialIndex = select.dataset.materialIndex;
            let cat = $(select).val();
            vueApp.getBoardProducts(cat, index, materialIndex);
        }

        function preProductionFormSubmit(){
            var self = $("#preProductionStoreForm");
            var formData = new FormData($(self)[0]);
            var url = $(self).attr('action');
            console.log(url);

            formPost(url, formData, function (res) {
                if(res.status == 200){
                    showSuccessAlert('Success',res.message)
                    setTimeout(function () {
                        window.location.href = "{{route('production.pre-production.index')}}";
                    }, 1000);
                }else{
                    showErrorAlert('Error',res.message)
                }
            }, 'show_input_error');
        }
        $(document).ready(function () {
            initMaterialProductMultipleSelect();
            initAssteProductMultipleSelect();
            initSelect2();
        });
    </script>
@endsection


