@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row" id="VueApp">
        <div class="erp-employee-list-wrapper">
            <div class="new-production-wrapper bg-card attd-table">
                <form action="{{route('production.pre-production.store')}}" id="preProductionStoreForm" method="POST" @submit="checkValidation">
                    @csrf
                    <div class="product-general-info-box d-flex flex-wrap">
                        <div class="pgib-item flex-35">
                            <div class="input-block erp-step-input-block mb-0">
                                <label class="col-form-label">Order Details <span class="text-red">*</span></label>
                                <input value="{{$pre_production->order_details}}" class="form-control" name="order_details" type="text" placeholder="" required="">
                            </div>
                        </div>
                        <div class="pgib-item flex-25">
                            <div class="input-block erp-step-input-block mb-0">
                                <label class="col-form-label">Image</label>
                                <input class="form-control" name="image" type="file" placeholder="">
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
                                <select class="select select-step" name="finished_goods_id">
                                    <option>Select Product</option>
                                    @foreach ($finished_products as $f_product)
                                        <option value="{{$f_product->id}}" {{$pre_production->finished_goods_id == $f_product->id? 'selected' : ''}}>{{$f_product->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="psib-item flex-30">
                            <div class="input-block erp-step-input-block mb-0">
                                <label class="col-form-label">Estimated Output QTY <span class="text-red">*</span></label>
                                <input class="form-control" value="{{$pre_production->estimated_production_qty}}" name="estimated_production_qty" type="text" placeholder="" required="">
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="production-process-wrapper process-wrapper" v-for="(process, index) in processes" :key="index">
                            <div class="production-process-status-wrapper">
                                <h4>Process @{{ index + 1 }}</h4>
                            </div>
                            <div class="production-machine-selection-wrapper d-flex flex-wrap">
                                <div class="pms-item flex-48">
                                    <div class="input-block erp-step-input-block mb-0">
                                        <label class="col-form-label">Machine Selection <span class="text-danger">*</span></label>
                                        <select class="machine-multiselect" name="machine_id[]" multiple="multiple" required>
                                            @foreach ($machines as $machine)
                                                <option value="{{$machine->id}}">{{$machine->name}}</option>  
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="pms-item flex-48" v-if="index > 0">
                                    <div class="input-block erp-step-input-block mb-0">
                                        <label class="col-form-label">Previous Process <span class="text-danger">*</span></label>
                                        <select class="process-multiselect" multiple="multiple">
                                            <option v-for="(process, idx) in processes.slice(0, index)" :key="idx">Process @{{ idx + 1 }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="production-matarial-selection-wrapper">
                                <h4 class="process-child-title">Material</h4>
                                <div class="pms-item-main-wrapper">
                                    <div class="pms-item-wrapper d-flex flex-wrap align-items-end" v-for="(materialSection, materialIndex) in process.materialSections" :key="materialIndex">
                                        <div class="pms-item flex-32">
                                            <div class="input-block erp-step-input-block mb-0">
                                                <label class="col-form-label">Category Selection <span class="text-danger">*</span></label>
                                                <select class="select select-step" name="product_material_category_id[]" v-model="materialSection.product_material_category_id" :data-index="index" :data-material-index="materialIndex" onchange="categoryChangeOutside(this)">
                                                    <option>Select Category</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="pms-item flex-32">
                                            <div class="input-block erp-step-input-block mb-0">
                                                <label class="col-form-label">Material Selection <span class="text-danger">*</span></label>
                                                <select name="product_material_id[]" class="select select-step material-product" v-if="processes && processes.length > 0">
                                                    <option value="">Select Material</option>
                                                    <template v-for="process in processes">
                                                        <template v-for="materialSection in process.materialSections">
                                                            <option v-for="product in materialSection.products" :key="product.id" :value="product.id">
                                                                @{{ product.name }}
                                                            </option>
                                                        </template>
                                                    </template>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="pms-item flex-15">
                                            <div class="input-block erp-step-input-block mb-0">
                                                <label class="col-form-label">QTY <span class="text-danger">*</span></label>
                                                <input v-model="materialSection.quantity" name="quantity[]" class="form-control " type="text" placeholder="" required="">
                                            </div>
                                        </div>
                                        <div class="pms-item flex-10">
                                            <div class="add-more-m-box d-flex justify-content-center gap-2 align-items-center">
                                                <a href="#" class="add-more-m-btn" @click.prevent="addMaterialSection(index)"><i class="la la-plus-circle"></i></a>
                                                <a v-if="materialIndex > 0" @click.prevent="removeMaterialSection(index,materialIndex)" href="#" class="add-more-m-btn remove-item"><i class="la la-times-circle"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="production-estimate-output-selection-wrapper">
                                <h4 class="process-child-title">Estimated Output</h4>
                                <div class="pms-item-main-wrapper">
                                    <div class="pms-item-wrapper d-flex flex-wrap align-items-end" v-for="(estimatedSection, estimatedIndex) in process.estimatedOutputs" :key="estimatedIndex">
                                        <div class="pms-item flex-60">
                                            <div class="input-block erp-step-input-block mb-0">
                                                <label class="col-form-label">Name <span class="text-danger">*</span></label>
                                                <input class="form-control" v-model="estimatedSection.name" name="name[]" type="text" placeholder="" required="">
                                            </div>
                                        </div>
                                        
                                        <div class="pms-item flex-15">
                                            <div class="input-block erp-step-input-block mb-0">
                                                <label class="col-form-label">QTY <span class="text-danger">*</span></label>
                                                <input class="form-control" v-model="estimatedSection.quantity" name="output_quantity[]" type="text" placeholder="" required="">
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
                                    <label class="col-form-label">Instruction <span class="text-danger">*</span></label>
                                    <textarea rows="1" v-model="process.process_instruction"  name="instruction[]" class="form-control" required></textarea>
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
                        <button class=" erp-search-btn text-center">Save Product</button>
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
    </style>
@endsection

@section('css_plugins')

@endsection

@section('js_plugins')
    <script src="{{asset('assets')}}/plugins/multipleselect/multiple-select.js"></script>
    <script src="{{asset('assets')}}/plugins/multipleselect/multi-select.js"></script> 

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
                };
            },
            computed: {

            },
            methods: {
                // getProcesses() {
                //     //const newIndex = this.processes.length + 1;
                //     axios
                //         .get('{{ route('production.pre-production.get-all-processes', 24) }}')
                //         .then(response => (
                //             console.log(response.data.processes)
                //             // this.processes.push({
                //             //     index: response.data.processes.length,
                //             //     materialSections: [{}],
                //             //     estimatedOutputs: [{}]
                //             // })
                //         ))
                // },

                getProcesses() {
                    axios
                        .get('{{ route('production.pre-production.get-all-processes', 24) }}')
                        .then(response => {
                            const processes = response.data.processes;
                            console.log(processes);
                            processes.forEach((process) => {
                                const materials = process.materials.map(material => {
                                    return {
                                        id: material.id,
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
                                this.processes.push({
                                    index: processes.length,
                                    process_id: process.id,
                                    process_instruction:  process.instruction,
                                    materialSections: materials,
                                    estimatedOutputs: estimated_output
                                });
                            });
                        })
                        .catch(error => {
                            console.error('Error fetching processes:', error);
                        });
                },




                addProcessHandler(){
                    const newIndex = this.processes.length + 1;
                    this.processes.push({
                        index: newIndex,
                        materialSections: [{}],
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

                addMaterialSection(processIndex){
                    this.processes[processIndex].materialSections.push({});
                    this.$nextTick(() => {
                        initSelect2();
                    });
                },

                removeMaterialSection(processIndex, materialIndex) {
                    this.processes[processIndex].materialSections.splice(materialIndex, 1);
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


            },
            mounted () {
                this.getProcesses();
                initMaterialProductMultipleSelect();
                initAssteProductMultipleSelect();
                initSelect2();
            }

        }).mount('#VueApp');


        // other functions
        function initSelect2() {
            $('.select-step').select2({
                minimumResultsForSearch: -1,
                width: '100%',
            });
        }
        function initAssteProductMultipleSelect(){
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
    </script>
@endsection


