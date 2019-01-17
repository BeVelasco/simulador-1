<br>
<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-2 col-xs-1"></div>
    <div class="col-lg-6 col-md-6 col-sm-8 col-xs-10">
        <div class="alert alert-dismissible bg-red" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            {{ Session::get('error') }}
        </div>
    </div>
</div>