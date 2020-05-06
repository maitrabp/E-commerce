<div class = "modal fade details-1" id = "details-1" tableindex = "-1" role = "dialog" aria-labelledby = "details-1" aria-hidden="true">
    <div class = "modal-dialog modal-lg">
        <div class = "modal-content">
            <div class = "modal-header">
            <button class = "close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title text-center" id="text3">Gucci Tracksuit</h4>
            </div>
            <div class = "modal-body">
                <div class = "container-fluid">
                    <div class = "row">
                        <div class = "col-sm-6">
                            <div class = "center-block">
                                <img src = "img/gucci_tracksuit.jpg" alt="Gucci Tracksuit" class = "details img-responsive"/>
                            </div>
                        </div>
                        
                        <div class = "col-sm-6">
                            <h4><b>Details</b></h4>
                            <p>This tracksuit is amazing. You must try it now!</p>
                            <hr/>
                            <p style = "color:maroon">Price: $699.99</p>
                            <p style = "color:maroon">Brand: Gucci</p>
                            <form action = "add_cart.php" method = "post">
                                <div class="form-group">
                                    <div class="col-xs-3">
                                        <label for="quantity" id="quantity-label" style = "color:maroon; margin-left: -15px">Quantity: </label>
                                        <input type="number" min = "1" style = "margin-left: -15px" class="form-control" id="quantity" name="quantity"/>
                                    </div> <br/><br/> <br/>
                                    <div class="form-group">
                                        <label for="size" id = "size-label" style = "color:maroon">Size: </label>
                                        <select name = "size" id = "size" class = "form-control">
                                            <option value = ""></option>
                                            <option value = "XS">XS</option>
                                            <option value = "S">S</option>
                                            <option value = "M">M</option>
                                            <option value = "L">L</option>
                                            <option value = "XL">XL</option>
                                            <option value = "XXL">XXL</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class = "modal-footer">
                <button class = "btn btn-default" data-dismiss = "modal">Close</button>
                <button class = "btn btn-warning" type="submit"><span class = "glyphicon glyphicon-shopping-cart"></span>Add To Cart</button>
            </div>
        </div>
    </div>
</div>