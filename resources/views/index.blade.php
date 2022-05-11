@extends('layouts.app')
@section('title','Ecommerce | Home Page')
@section('content')
  
    <!-- Home slider -->
    @include('front.files.slider')
    <!-- Home slider end -->
   {{-- banner --}}

    <!-- collection banner -->
   
    <!-- collection banner end -->
    @include('front.files.latest')

    <!-- Paragraph-->
   
    <!-- Product slider end -->

    @include('front.files.isotop')
   

    <!--  logo section -->
    @include('front.files.brand')
    <!--  logo section end-->
@endsection