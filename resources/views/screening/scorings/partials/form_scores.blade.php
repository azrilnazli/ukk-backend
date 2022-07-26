
<div class="d-flex col-8 mt-5 mb-5">

    <div class="p-2"></div>
    <div class="p-2"></div>

    @if(!empty($screeningScoring))
        <div class="ml-auto p-2">
            <h1>JUMLAH : <span class="badge badge-dark">{{ $screeningScoring->total_score }}%</span></h1>
        </div>
    @else
        <div class="ml-auto p-2">
            <h1>JUMLAH : <span class="badge badge-dark"><span id="result">0</span>%</span></h1>
        </div>
    @endif
</div>


<script>
    $(document).ready(function(){

        console.log('realtime scoring')

        var forms = ['criteria','storyline','creativity','technical','acting','value_added'];

        var final = [];

        $.each( forms, function( index, value ) {
            //alert( index + ": " + value );
            $("#form_" + value).change(function(){
                var score = parseInt(this.value); ;

                final[index] = score;
                const total = final.reduce((partialSum, a) => partialSum + a, 0);
                //const final_score = Math.round((total/60)*100);
                console.log(total);
                $("#result").html(total);

            });
        });


    });
    </script>
