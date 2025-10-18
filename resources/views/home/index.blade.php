@extends('home.template')
@section('title', 'Beranda')
@section('body')
 <!--======= HOME MAIN SLIDER =========-->
    <section class="home-slider">
        <div class="tp-banner-container">
            <div class="tp-banner">
                <ul>
                    <!-- Slider 1 -->
                    <li data-transition="fade" data-slotamount="7"> <img
                            src="{{ asset('home/images/bg/ban1.jpg') }}"
                            data-bgposition="center center" alt="" />
                        <!-- Overlay Layer -->
                        <div class="slider-overlay"></div>
                        <!-- Layer -->
                        <div class="tp-caption sft font-montserrat tp-resizeme" data-x="center" data-hoffset="0"
                            data-y="center" data-voffset="-100" data-speed="700" data-start="1000"
                            data-easing="easeOutBack"
                            data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
                            data-splitin="none" data-splitout="none" data-elementdelay="0.1"
                            data-endelementdelay="0.1" data-endspeed="300" data-captionhidden="on"
                            style="color: #fff; font-size: 60px; text-transform: uppercase; font-weight:bolder; letter-spacing:3px;">
                            Museum Huta Bolon
                        </div>

                        <!-- Layer -->
                        <div class="tp-caption sfb  font-montserrat text-center tp-resizeme" data-x="center"
                            data-hoffset="0" data-y="center" data-voffset="-20" data-speed="700" data-start="1500"
                            data-easing="easeOutBack"
                            data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
                            data-splitin="none" data-splitout="none" data-elementdelay="0.1"
                            data-endelementdelay="0.1" data-endspeed="300" data-captionhidden="on"
                            style="color: #fff; font-size: 18px; font-weight:100; text-transform: uppercase;">
                            Jelajahi Warisan Budaya dan Sejarah yang Kaya di Kabupaten Samosir <br>
                            📍 Eksplorasi yang seru, edukatif, dan menginspirasi menanti kamu.

                        </div>

                        <!-- Layer -->
                        <div class="tp-caption sfb tp-resizeme" data-x="center" data-hoffset="0" data-y="center"
                            data-voffset="80" data-speed="700" data-start="2000" data-easing="easeOutBack"
                            data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
                            data-splitin="none" data-splitout="none" data-elementdelay="0.1"
                            data-endelementdelay="0.1" data-endspeed="300" data-captionhidden="on"> <a href="#."
                            class="btn">Explore</a> &nbsp; &nbsp; &nbsp; &nbsp;
                        </div>
                    </li>

                    <!-- Slider 2 -->
                    <li data-transition="fade" data-slotamount="7"> <img
                        src="{{ asset('home/images/bg/ban2.jpg') }}"
                        data-bgposition="center center" alt="" />

                        <!-- Overlay Layer -->
                        <div class="slider-overlay"></div>

                        <!-- Layer -->
                        <div class="tp-caption sft font-montserrat tp-resizeme" data-x="center" data-hoffset="0"
                            data-y="center" data-voffset="-100" data-speed="700" data-start="1000"
                            data-easing="easeOutBack"
                            data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
                            data-splitin="none" data-splitout="none" data-elementdelay="0.1"
                            data-endelementdelay="0.1" data-endspeed="300" data-captionhidden="on"
                            style="color: #fff; font-size: 60px; text-transform: uppercase; font-weight:bolder; letter-spacing:3px;">
                            Museum Huta Bolon
                        </div>

                        <!-- Layer -->
                        <div class="tp-caption sfb  font-montserrat text-center tp-resizeme" data-x="center"
                            data-hoffset="0" data-y="center" data-voffset="-20" data-speed="700" data-start="1500"
                            data-easing="easeOutBack"
                            data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
                            data-splitin="none" data-splitout="none" data-elementdelay="0.1"
                            data-endelementdelay="0.1" data-endspeed="300" data-captionhidden="on"
                            style="color: #fff; font-size: 18px; font-weight:100; text-transform: uppercase;">
                            Jelajahi Warisan Budaya dan Sejarah yang Kaya di Kabupaten Samosir <br>
                            📍 Eksplorasi yang seru, edukatif, dan menginspirasi menanti kamu.
                        </div>

                        <!-- Layer -->
                        <div class="tp-caption sfb tp-resizeme" data-x="center" data-hoffset="0" data-y="center"
                            data-voffset="80" data-speed="700" data-start="2000" data-easing="easeOutBack"
                            data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
                            data-splitin="none" data-splitout="none" data-elementdelay="0.1"
                            data-endelementdelay="0.1" data-endspeed="300" data-captionhidden="on"> <a href="#."
                            class="btn">Explore</a> &nbsp; &nbsp; &nbsp; &nbsp;
                        </div>
                    </li>

                    <!-- Slider 3 -->
                    <li data-transition="fade" data-slotamount="7"> <img
                        src="{{ asset('home/images/bg/ban3.jpg') }}"
                        data-bgposition="center center" alt="" />

                        <!-- Overlay Layer -->
                        <div class="slider-overlay"></div>

                        <!-- Layer -->
                        <div class="tp-caption sft font-montserrat tp-resizeme" data-x="center" data-hoffset="0"
                            data-y="center" data-voffset="-100" data-speed="700" data-start="1000"
                            data-easing="easeOutBack"
                            data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
                            data-splitin="none" data-splitout="none" data-elementdelay="0.1"
                            data-endelementdelay="0.1" data-endspeed="300" data-captionhidden="on"
                            style="color: #fff; font-size: 60px; text-transform: uppercase; font-weight:bolder; letter-spacing:3px;">
                            Museum Huta Bolon
                        </div>

                        <!-- Layer -->
                        <div class="tp-caption sfb  font-montserrat text-center tp-resizeme" data-x="center"
                            data-hoffset="0" data-y="center" data-voffset="-20" data-speed="700" data-start="1500"
                            data-easing="easeOutBack"
                            data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
                            data-splitin="none" data-splitout="none" data-elementdelay="0.1"
                            data-endelementdelay="0.1" data-endspeed="300" data-captionhidden="on"
                            style="color: #fff; font-size: 18px; font-weight:100; text-transform: uppercase;">
                            Jelajahi Warisan Budaya dan Sejarah yang Kaya di Kabupaten Samosir <br>
                            📍 Eksplorasi yang seru, edukatif, dan menginspirasi menanti kamu.
                        </div>

                        <!-- Layer -->
                        <div class="tp-caption sfb tp-resizeme" data-x="center" data-hoffset="0" data-y="center"
                            data-voffset="80" data-speed="700" data-start="2000" data-easing="easeOutBack"
                            data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
                            data-splitin="none" data-splitout="none" data-elementdelay="0.1"
                            data-endelementdelay="0.1" data-endspeed="300" data-captionhidden="on"> <a href="#."
                            class="btn">Explore</a> &nbsp; &nbsp; &nbsp; &nbsp;
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- CONTENT START -->
    <div class="content">

        <!--======= ABOUT US =========-->
        {{-- <section class="sec-100px about">
            <div class="container">
                <div class="row">

                    <!-- INTRO -->
                    <div class="col-md-7">
                        <h4>National Museum is a largest research and museum. more than 197 countries objects in history </h4>
                        <hr>
                        <p>Scelerisque, felis eget Auctor dictum tempus molestie auctor consectetuer sit nisl,
                            tempor, ultrices velit nascetur ullamcorper torquent adipiscing felis interdum. Vel
                            nibh. Eget maecenas gravida urna nascetur sit. Taciti at suspendisse rutrum.
                        </p>
                        <a href="#.">Buy Tickets <i class="fa fa-angle-right"></i></a>
                    </div>

                    <!-- TIMING -->
                    <div class="col-md-5">
                        <div class="hrs">
                            <h3><i class="ion-ios-clock-outline"></i> Hours of visiting</h3>
                            <ul>
                                <li class="col-md-5 no-padding">
                                    <h5>Mon - Wed</h5>
                                    <p>8:00 Am to 7:00 Pm</p>
                                </li>
                                <li class="col-md-7 no-padding"> <span class="appoiment">School appoinments</span>
                                </li>
                            </ul>
                            <ul>
                                <li class="col-md-5 no-padding">
                                    <h5>Thu - Sun</h5>
                                    <p>8:00 Am to 7:00 Pm</p>
                                </li>
                                <li class="col-md-7 no-padding"> <span class="appoiment">Tourists appoinments</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section> --}}

        <!--======= HISTORY =========-->
        <section class="history">
            <div class="row">

                <!-- IMAGE -->
                <div class="col-md-4 no-padding">
                    <div class="museum-img"> </div>
                </div>

                <!-- History Content -->
                <div class="col-md-8 no-padding">
                    <div class="history-detail">
                        <ul class="row">
                            <li class="col-md-3">
                                <h4>Profil</h4>
                                <hr>
                            </li>
                            <li class="col-md-9">
                                <p>Museum Huta Bolon Simanindo merupakan rumah tradisional Batak warisan dari Raja Sidauruk sejak tahun 1969.
                                    Museum ini terletak di Desa Simanindo, Kecamatan Simanindo, Kabupaten Samosir, Provinsi Sumatera Utara. <br>
                                    <br>
                                    Di Museum Huta Bolon Simanindo terdapat dua susun rumah adat yang saling berhadapan dan tiap susunnya terdiri dari lima rumah.
                                    Kepemilikan rumah adat ini oleh Huta Bolon Simanindo. Koleksinya berupa peninggalan leluhur orang batak dari Samosir yang terdiri antara lain parhalaan,
                                    pustaha laklak, tunggal panaluan dan solu bolon.
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!--======= Gallery =========-->
        <section class="sec-100px gallery">
            <div class="container">

                <!-- Tittle -->
                <div class="tittle">
                    <h2>GALLERY</h2>
                    <hr>
                    <p>Jelajahi Galeri Museum Huta Bolon Simanindo
                    </p>
                </div>
                <ul class="row">
                    @forelse ($gallery as $item)
                    {{-- @dd($item->kategori) --}}
                        <li class="col-sm-4">
                            <div class="inn-sec"> <span class="tag">{{ $item->kategori->first()->nama_kategori ?? 'Unknown' }}</span>
                                <!-- Hover Info -->
                                {{-- <div class="hover-info">
                                    <div class="position-center-center">
                                        <a href="images/img-1.jpg" data-rel="prettyPhoto" class="prettyPhoto lightzoom zoom">
                                            <i class="ion-image"></i>
                                        </a>
                                    </div>
                                </div> --}}
                                <img class="img-responsive"
                                    src="{{ asset($item->gambarVideo->where('jenis', 'gambar')->first()->link ?? 'home/images/img-1.jpg') }}"
                                    alt="" style="aspect-ratio: 1 / 1;">
                                <div class="detail">
                                    <a href="#.">{{ $item->nama }}</a>
                                    <p><span>Lokasi</span>: {{ $item->lokasi }}</p>
                                </div>
                            </div>
                        </li>
                    @empty
                        <p class="text-center">Tidak ada data gallery</p>
                    @endforelse
                </ul>
            </div>
        </section>

        <!--======= Event =========-->
        <section class="sec-100px event">
            <div class="container">

                <!-- Tittle -->
                <div class="tittle">
                    <h2>EVENTS</h2>
                    <hr>
                    <p>Jangan lewatkan berbagai event menarik yang akan digelar di Museum Huta Bolon Simanindo!.</p>
                </div>

                <!-- Event -->
                <div class="row">
                    <!-- Event 1 -->
                    @forelse ($events as $event)
                    <div class="col-md-6">
                        <ul>
                            <!-- Image -->
                            <li class="col-sm-6 no-padding">
                                <img class="img-responsive" src="{{ asset($event->thumbnail) }}" alt="" style="aspect-ratio: 1 / 1;">
                                <div class="date">
                                    {{ \Carbon\Carbon::parse($event->tanggal_event)->format('d') }}
                                    <p>{{ \Carbon\Carbon::parse($event->tanggal_event)->translatedFormat('F, Y') }}</p>
                                </div>
                            </li>

                        <!-- Detail -->
                            <li class="col-sm-6 no-padding">
                                <div class="event-detail">
                                    <h4> {{ $event->nama_event }} </h4>
                                    {{-- <span><i class="ion-ios-location-outline"></i> Melbourne, Australia </span> --}}
                                    <span><i class="ion-ios-clock-outline"></i> {{ $event->waktu_event }}</span>
                                    <p>{!! $event->deskripsi_event !!}</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    @empty
                        <p class="text-center">Tidak ada data event</p>
                    @endforelse

                </div>
            </div>
        </section>
    </div>

@endsection
