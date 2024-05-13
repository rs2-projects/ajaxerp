@if(session()->has('is_admin_access') && (session()->get('is_admin_access') === true) && (session()->get('admin_user_id') != ''))
<div class="text-center">
    <a href="{{ route('hr.employee.login.back-to-admin') }}"><i class="fa fa-arrow-left"></i> Back To Your Account</a>
</div>
@endif