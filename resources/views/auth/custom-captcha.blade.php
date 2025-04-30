<div class="col-6 pr-0">
    <input type="text" class="form-control form-control-lg border-0" name="custome_recaptcha"
            id="custome_recaptcha" required placeholder="Captacha" autocomplete="off" value="">
</div>
<div class="col-6 bg-white rounded d-flex">
    <img src="" class="rounded w-100" />
    <div class="p-3 pr-0 capcha-spin" onclick="reloadCaptcha()">
        <i class="tio-cached"></i>
    </div>  
    {{-- <a class="" onclick="reloadCaptcha()">
        <i class="tio-edit"></i>
    </a> --}}
</div>