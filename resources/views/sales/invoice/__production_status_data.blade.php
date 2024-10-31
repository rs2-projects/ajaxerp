<ul >
    @foreach ($prouctions as $production)
        @if($production->production_status == 'design_stage') 
            <li>
                <p>This Production with Batch Number <strong>{{ $production->pre_production_batch_no }}</strong> is in the <strong>Design Stage</strong>.</p>
            </li>
        @elseif($production->production_status == 'pending_production')
            <li>
                <p>The Pre Production with Batch Number <strong>{{ $production->pre_production_batch_no }}</strong> has been completed and is going into <strong>Production</strong>.</p>
            </li>
        @elseif($production->production_status == 'completed_production')
            <li>
                <p>The Production with Batch Number <strong>{{ $production->pre_production_batch_no }}</strong> has been completed and is set to be <strong>delivered</strong>.</p>
            </li>
        @else
            <li>
                <p>The Production with Batch Number <strong>{{ $production->pre_production_batch_no }}</strong>  is in the <strong>{{ $production->process_name }} Stage</strong>.</p>
            </li>

        @endif
    @endforeach
</ul>