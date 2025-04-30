<div class="card-header border-0 text-center">
    <h4>Stock</h4>
    <input name="product_id" value="{{$product['id']}}" class="initial-hidden">
</div>
<div class="card-body">
    <div class="form-group">
        <div class="mb-4">
            <div class="variant_combination" id="variant_combination">
                @include('vendor-views.product.partials._edit-combinations',['combinations'=>json_decode($product['variations'],true),'stock'=>config('module.'.$product->module->module_type)['stock']])
            </div>
            <div id="quantity">
                <label class="form-label" for="total_stock">{{translate('messages.total_stock')}}</label>
                <input type="number" min='0' class="form-control" name="current_stock" value="{{$product->stock}}" id="quantity" {{count(json_decode($product['variations'],true)) > 0 ? 'readonly' : ""}}>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
        $('.nettoPrice').change(function() {
            var nettoPrice = parseFloat($(this).val());
            var bruttoPrice = nettoPrice * (1 + ("{{$product['tax']}}" / 100));
            $(this).closest('tr').find('.bruttoPrice').val(formatPrice(bruttoPrice));
        });

        // Event listener for bruttoPrice change
        $('.bruttoPrice').change(function() {
            var bruttoPrice = parseFloat($(this).val());
            var nettoPrice = bruttoPrice / (1 + ("{{$product['tax']}}" / 100));
            $(this).closest('tr').find('.nettoPrice').val(formatPrice(nettoPrice));
        });
    });
</script>