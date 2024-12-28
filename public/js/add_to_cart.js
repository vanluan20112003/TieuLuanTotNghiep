$(document).ready(function(){
    // Bắt sự kiện khi nhấn vào nút thêm vào giỏ hàng
    $('.add-to-cart-btn').click(function(e) {
        e.preventDefault();
        
        var button = $(this);
        var productId = button.closest('.box').find('.product-id').val();
        var qty = button.closest('.box').find('.qty').val();

        $.ajax({
            url: '{{ route("add.to.cart") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                product_id: productId,
                qty: qty
            },
            success: function(response) {
                alert('Sản phẩm đã được thêm vào giỏ hàng!');
                // Cập nhật giao diện giỏ hàng nếu cần
            },
            error: function(response) {
                alert('Có lỗi xảy ra. Vui lòng thử lại.');
            }
        });
    });
});
