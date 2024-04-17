<div id="verifyOutput">
    <div class="erp-modal-body-content">
        @foreach ($estimated_outputs as $data)
            <table class="table mb-0 erp-table">
                <thead class="erp-thead">
                    <tr class="erp-tr">
                        <th class="erp-th">Name</td>
                        <th class="erp-th">Verify</td>
                    </tr>
                </thead>
                <tbody class="erp-tbody">
                    @for ($i = 1; $i <= $data->quantity; $i++ )
                        <tr class="erp-tbody-tr">
                            <td class="erp-tbody-td text-left">{{ $data->name }}</td>
                            <td class="erp-tbody-td text-left">
                                <div class="checkbox-wrapper">
                                    <input  id="terms-checkbox-{{$i}}" name="checkbox" {{ ($data->verified_qtn >= $i)?'checked disabled':'' }} type="checkbox"
                                        onclick="verifyOutput('{{ route('production-staff.production.production.verify-output.update', $data->id) }}')">
                                    <label class="terms-label justify-content-start" for="terms-checkbox-{{$i}}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 200 200" class="checkbox-svg">
                                        <mask fill="white" id="path-1-inside-1_476_5-37">
                                            <rect height="200" width="200"></rect>
                                        </mask>
                                        <rect mask="url(#path-1-inside-1_476_5-37)" stroke-width="40" class="checkbox-box" height="200" width="200"></rect>
                                        <path stroke-width="15" d="M52 111.018L76.9867 136L149 64" class="checkbox-tick"></path>
                                        </svg>
                                        <span class="label-text">{{$data->verified_qtn >= $i ? 'Verified': 'Verify' }}</span>
                                    </label>
                                </div>
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        @endforeach
        {{-- <div class="submit-section mt-2">
            <button class="btn btn-primary submit-btn" type="submit">Verify</button>
        </div> --}}
    </div>
</div>
