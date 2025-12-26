$(document).ready(function () {
    $("#productForm").validate({
        rules: {
            category_name: {
                required: true
            },
            sub_category_name: {
                required: true
            },
            product_name: {
                required: true,
                minlength: 3
            },
            product_details: {
                required: true,
                minlength: 10
            },
            product_type: {
                required: true
            },
            product_color: {
                required: true
            },
            "product_brand[]": {
                required: true
            },
            product_price: {
                required: true,
                number: true,
                min: 1
            }
        },
        messages: {
            category_name: "Please select a category",
            sub_category_name: "Please select a sub-category",
            product_name: {
                required: "Enter a product name",
                minlength: "Product name must be at least 3 characters"
            },
            product_details: {
                required: "Enter product details",
                minlength: "Details must be at least 10 characters"
            },
            product_type: "Please select a product type",
            product_color: "Please select a color",
            "product_brand[]": "Select at least one brand",
            product_price: {
                required: "Enter a price",
                number: "Enter a valid number",
                min: "Price must be at least 1"
            }
        },
        errorElement: "span",
        errorClass: "text-danger",
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        }
    });
});
