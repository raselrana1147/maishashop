    <section class="p-0">
        <div class="slide-1 home-slider">
            @foreach ($sliders as $slider)
            <div>
                <div class="home  text-center">
                    <img src="{{ asset('assets/backend/image/slider/large/'.$slider->image)}}" alt="" class="bg-img blur-up lazyload">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="slider-contain">
                                    <div>
                                        <h4>{{$slider->title_1}}</h4>
                                        <h1>{{$slider->title_2}}</h1>
                                        <a href="{{$slider->url}}" class="btn btn-solid">{{$slider->button_title}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
     
    </section>