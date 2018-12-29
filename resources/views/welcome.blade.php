<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
    </head>
    <body id="app">
    <br>
            <div class="content">
                <div class="container">
                    <div id="errors"></div>
                    <div class="col-lg-12">
                        <form class="form-horizontal" id="productForm">
                            <div class="form-group">
                                <label for="prod_name">
                                    Product Name
                                </label>
                                <input id="prod_name" required name="name" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="quantity">
                                    Quantity in stock
                                </label>
                                <input id="quantity" required name="quantity" type="number" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="price">
                                    Price
                                </label>
                                <input id="price" required name="price" type="number" class="form-control">
                            </div>
                            <div class="form-group">
                                <button type="button" id="save-btn" class="btn btn-block btn-primary">
                                    Save
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-12" id="products">
                    </div>
                    
                </div>
            </div>
    </body>
    <script>
        (function ($) {

          const  saveData  =  (e) => {
              $('#save-btn').prop('diabled', true).html('Please Wait....')
                const data = $("#productForm").serialize();
                $.ajax({
                    url: '/api/products',
                    data: data,
                    type: 'POST'
                }).done(function(response){
                    $('#errors').html(
                               `
                               <div class="alert alert-success fade show" role="alert">
                                    <strong>Saved!</strong>. Product Saved
                                </div>
                               `
                           )
                    setTimeout(function(){
                        window.location.reload()
                    }, 2000)
                }).fail(function (response) {
                    $('#save-btn').prop('diabled', false).html('Save')
                           $('#errors').html(
                               `
                               <div class="alert alert-danger fade show" role="alert">
                                    <strong>Error!</strong> Unable to save product
                                </div>
                               `
                           )
                })
            }

            $(document.body).on('click','#save-btn', saveData)
            $(document.body).ready(function() {

                var html  = `
                <table class="table table-responsive table-striped">
                            <thead>
                                <th>id</th>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                            </thead>
                        <tbody>
                `;
                $.ajax({
                  url: '/api/products',
                  type: 'GET'
              }).done(function(response){
                if(response.data.length){
                    $.each(response.data, function(index, product){
                        html += '<tr>'
                        html += `<td>${product.id}</td>`
                        html += `<td>${product.name}</td>`
                        html += `<td>${product.quantity}</td>`
                        html += `<td>${product.price}</td>`
                        html += '</tr>'
                        
                    })
                    html += '</tbody>'
                    html += '</table>'
                    $('#products').html(html)
                }
              }).fail(function () {
                  console.log('fialed')
              })
            })
        }(window.jQuery))

    </script>
</html>
