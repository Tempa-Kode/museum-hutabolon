@extends("home.template")
@section("title", "Beranda")
@section("body")
    <!--======= HOME MAIN SLIDER =========-->
    <section class="sub-bnr sub-gallery" data-stellar-background-ratio="0.3">
        <div class="overlay-gr">
            <div class="container">
                <h2>Events</h2>
                <p>Temukan Berbagai Event Menarik yang Akan Datang di Museum Huta Bolon Simanindo</p>
            </div>
        </div>
    </section>
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li><a href="{{ route('home') }}">Home</a></li>
        <li class="active">Events</li>
    </ol>

    <div class="content">
        <div class="container">

            <!--======= Event =========-->
            <section class="sec-100px event event-page">
                <div class="container">

                    <!-- Event -->
                    <div class="row">
                        <div class="col-md-8">

                            <!-- Event -->
                            @forelse ($data as $item)
                                <ul>
                                    <!-- Image -->
                                    <li class="col-sm-5 no-padding eve-img">
                                        <img class="img-responsive h-100"
                                            src="{{ asset($item->thumbnail) }}"
                                            alt=""
                                            style="object-fit: cover;"
                                        >
                                        <div class="date">
                                            {{ \Carbon\Carbon::parse($item->tanggal_event)->format('d') }}
                                            <p>{{ \Carbon\Carbon::parse($item->tanggal_event)->translatedFormat('F, Y') }}</p>
                                        </div>
                                    </li>

                                    <!-- Detail -->
                                    <li class="col-sm-7 no-padding">
                                        <div class="event-detail">
                                            <h4> {{ $item->nama_event }} </h4>
                                            <span>
                                                <i class="ion-ios-clock-outline"></i> {{ $item->waktu_event }}
                                            </span>
                                            <p>
                                                {!! $item->deskripsi_event !!}
                                            </p>
                                        </div>
                                    </li>
                                </ul>
                            @empty

                            @endforelse

                            <!-- Pagination -->
                            <ul class="pagination">
                                {{ $data->links() }}
                            </ul>
                        </div>

                        <!-- Sidebar -->
                        <div class="col-md-4">
                            <div class="side-bar">

                                <!-- Search -->
                                <div class="search">
                                    <form action="{{ route('events') }}" method="GET">
                                        <input type="text" name="search" placeholder="SEARCH EVENT . . .">
                                        <button type="submit"> <i class="fa fa-search"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
