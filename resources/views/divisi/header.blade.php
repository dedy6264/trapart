 <!-- Masthead-->
 <header class="masthead">
    <div class="container position-relative">
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <div class="text-center text-white">
                    <!-- Page heading-->
                    <h1 class="mb-5">Pantau perjalanan kurir favoritmu disini</h1>
                    <!-- Signup form-->
                    <!-- * * * * * * * * * * * * * * *-->
                    <!-- * * SB Forms Contact Form * *-->
                    <!-- * * * * * * * * * * * * * * *-->
                    <!-- This form is pre-integrated with SB Forms.-->
                    <!-- To make this form functional, sign up at-->
                    <!-- https://startbootstrap.com/solution/contact-forms-->
                    <!-- to get an API token!-->
                    <form class="form-subscribe" id="contactForm" action="{{route('resi');}}" method="POST">
                        <!-- Email address input-->
                        <div class="row">
                                @csrf
                                <div class="col">
                                    <select name="kurir" class="form-control form-control-lg" id="emailAddress">
                                        @foreach ($c as $kurir)
                                        <option value="{{$kurir->id}}">{{$kurir->courier_name}}</option>
                                        @endforeach
                                </select></div>
                            <div class="col">
                                <input class="form-control form-control-lg" id="emailAddress" type="text" placeholder="Resi" name="resi" />
                            </div>
                            <div class="col-auto"><button class="btn btn-primary btn-lg" id="submitButton" type="submit">Submit</button></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>