@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        <div class="erp-employee-list-wrapper">
            <div class="erp-main-filter-wrapper bg-card attd-table">
                <div class="my-attendance-box-item flex-100 ">
                    <div class="my-attendance-report-wrapper">
                        <div class="my-attendance-report-wrapper" id="ajax-data-load">
                            <div class="big-table pt-4">
                                <div class="de-table-wrapper">
                                    <div class="table-responsive">
                                        <table class="table mb-0 erp-table monitoring-table">
                                            <thead class="erp-thead">
                                                <tr class="erp-tr">
                                                    <th class="erp-th text-center">Production Order</th>
                                                    @foreach ($machines as $machine)
                                                        <th class="erp-th">{{ $machine->name }}</th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody class="erp-tbody">
                                                @foreach($productions as $production)
                                                    <tr class="erp-tbody-tr">
                                                        <td class="erp-tbody-td">
                                                            <h4 class="title">{{ $production->pre_production_batch_no }}</h4>
                                                        </td>
                                                        {{-- @php($maxMachine = rand(1, 10))
                                                        @php($onProcess = rand(1, $maxMachine))
                                                        @for ($j = 1; $j <= 10; $j++)
                                                            <td class="erp-tbody-td text-center status {{ ($j <= $maxMachine) ? (($onProcess == $j)?'on-going':'done'):'' }}">
                                                                @if($j <= $maxMachine)
                                                                    @if($onProcess == $j)
                                                                        On Going
                                                                    @else
                                                                        Done
                                                                    @endif
                                                                @endif
                                                            </td>
                                                        @endfor --}}
                                                        @foreach ($machines as $machine)
                                                            @php($machineProduction = $production->productionMachines->where('machine_id', $machine->id)->first())
                                                            @if(!empty($machineProduction))
                                                                @if($machineProduction->preProductionProcess->process_status == App\Models\Production\PreProductionProcess::PROCESS_STATUS_PENDING)
                                                                    <td class="erp-tbody-td text-center">
                                                                        
                                                                    </td>
                                                                @else
                                                                    @if($machineProduction->preProductionProcess->process_status == App\Models\Production\PreProductionProcess::PROCESS_STATUS_PROCESSING)
                                                                        <td class="erp-tbody-td text-center status on-going">
                                                                            On Going
                                                                        </td>
                                                                    @elseif ($machineProduction->preProductionProcess->process_status == App\Models\Production\PreProductionProcess::PROCESS_STATUS_COMPLETED)
                                                                        <td class="erp-tbody-td text-center status done">
                                                                            Done
                                                                        </td>
                                                                    @else
                                                                        <td class="erp-tbody-td text-center">
                                                                            
                                                                        </td>
                                                                    @endif
                                                                    
                                                                @endif
                                                            @else
                                                                <td class="erp-tbody-td text-center">
                                                                    
                                                                </td>
                                                            @endif
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        

    </div>
    <!--End::row-1 -->

</div>
@endsection

@section('modals')
    
@endsection

@section('css')

@endsection

@section('css_plugins')

@endsection

@section('js_plugins')

@endsection

@section('js')
    <script>
        
    </script>
@endsection


