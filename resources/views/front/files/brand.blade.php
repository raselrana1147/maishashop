 <section class="section-b-space">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="slide-6 no-arrow">
                        @foreach (brands() as $brand)
                           
                        <div>
                            <div class="logo-block">
                                <a href="{{ route('product.brand_wise_product',$brand->id) }}"><img src="{{ asset('assets/backend/image/brand/small/'.$brand->image)}}" alt=""></a>
                            </div>
                        </div>
                        @endforeach
                      
                    </div>
                </div>
            </div>
        </div>
    </section>