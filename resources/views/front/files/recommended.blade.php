  <div class="container">
        <div class="row">
            <div class="col">
                <div class="title1 section-t-space">
                   
                    <h2 class="title-inner1">Product for you</h2>
                </div>
            </div>
        </div>
    </div>
    <section class="blog pt-0 ratio2_3">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="slide-3 no-arrow slick-default-margin">
                        @foreach ($recommendeds as $recommended)
                          
                        <div class="col-md-12">
                            <a href="{{ route('product.detail',$recommended->id) }}">
                                <div class="classic-effect">
                                    <div>
                                        <img src="{{ asset('assets/backend/image/product/small/'.$recommended->thumbnail)}}" class="img-fluid blur-up lazyload bg-img"
                                            alt="">
                                    </div>
                                    <span></span>
                                </div>
                            </a>
                            <div class="blog-details">
                                <h4>{{$recommended->name}}</h4>
                                <a href="#">
                                    <p>{{currency()}}{{number_format($recommended->current_price,2)}}</p>
                                </a>
                              
                            </div>
                        </div>
                        
                     @endforeach
                     
                    </div>
                </div>
            </div>
        </div>
    </section>