
        <div class="form-group">
            <h5>Kategori Syarikat</h5>
            <div class="form-check">
                <input 
                    class="form-check-input" 
                    type="radio" 
                    name="assessment" 
                    value="berwibawa"
                    @if(old('assessment') == 'berwibawa') checked @endif
                />
                <label class="form-check-label">
                Syarikat Berwibawa
                </label>
            </div>
            <div class="form-check">
                <input 
                    class="form-check-input" 
                    type="radio" 
                    name="assessment" 
                    value="berupaya"
                    @if(old('assessment') == 'berupaya') checked @endif
                />
                <label class="form-check-label">
                Syarikat Berupaya
                </label>
            </div>
            <div class="form-check">
                <input 
                    class="form-check-input" 
                    type="radio" 
                    name="assessment" 
                    value="baharu"
                    @if(old('assessment') == 'baharu') checked @endif
                />
                <label class="form-check-label">
                Syarikat Baharu
                </label>
            </div>        
        </div>

        <hr />

        <div class="form-group">
            <h5>Menepati <i>Need Statement</i> ?</h5>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="need_statement_comply" value="true" @if(old('need_statement_comply')) checked @endif>
                <label class="form-check-label">
                  Ya
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="need_statement_comply"  value="false" @if(!old('need_statement_comply')) checked @endif>
                <label class="form-check-label">
                  Tidak
                </label>
            </div>
        </div>  
        
        <hr />

        <div class="form-group">
            <div class="row text-uppercase font-weight-bold p2">
                <div class="col-1">No.</div>
                <div class="col-2">Perkara</div>
                <div class="col-1 text-center">Sesuai</div>
                <div class="col-1 text-center">Tidak Sesuai</div>
                <div class="col-6">Ulasan</div>
            </div>

            @php 
                $scores = ['tajuk','sinopsis','idea_dan_subjek','lengkap','menepati_keperluan_asas']
            @endphp

            @foreach($scores as $key => $score)
            <div class="row mt-3">
                <div class="col-1">{{$key+1}}.</div>
                <div class="col-2 text-uppercase">{{ str_replace('_', ' ' , $score) }}</div>
                <div class="col-1  text-center">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="{{ $score }}_status"  value="true" @if(old( $score . '_status')) checked @endif>
                    </div>
                </div>
                <div class="col-1 text-center">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="{{ $score }}_status"  value="false" @if(!old( $score . '_status')) checked @endif>
                    </div>
                </div>
                <div class="col-6">
                        <textarea class="form-control" name="{{ $score }}_message" rows="3">{{ old( $score . '_status') }}</textarea>
                </div>
            </div>
            @endforeach
                 
        </div>       
        <hr />
        
        <div class="form-group">
            <h5>Pengesyoran</h5>
            <div class="row mt-3 mr-3">
                <div class="col pr-3">
                    <div class="row">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="syor_status" value="true" @if(old( 'syor_status')) checked @endif>
                            <label class="form-check-label">
                            Disokong
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <textarea class="form-control" name="syor_true" rows="5">{{ old( 'syor_true') }}</textarea>
                    </div>
                    
                </div>
                <div class="col">
                    <div class="row">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="syor_status" value="false" @if(!old( 'syor_status')) checked @endif>
                            <label class="form-check-label">
                            Tidak disokong
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <textarea class="form-control" name="syor_false" rows="5">{{ old( 'syor_false') }}</textarea>
                    </div>
                </div>
            </div>
        </div>
