@extends('layout.frontend.header')
@section('content')
<section>
    <div class="row-block statc-tm sttc-cl-th">
        <h2><strong>{{_i('Privacy Policy')}}</strong></h2>
        <div class="row-bx">
            <div class="col-12">
                <div class="sttc-rw">
                    <p> 
                    @if(isset($localelang) && $localelang=='de-CH')

                        {!!$pcontant[0]->description_ch!!}

                    @elseif(isset($localelang) && $localelang=='fr-CH')

                        {!!$pcontant[0]->description_fr!!}

                    @else

                        {!!$pcontant[0]->description!!}

                    @endif
                    </p>
                </div>
                
            </div>
        </div>    
    </div>
</section>
@endsection
<!-- /CONTENT -->
      