
        <div class="form-group">
            <h5>Kategori Syarikat</h5>
            <div class="form-check">
                <input
                    class="form-check-input @error('assessment') is-invalid @enderror"
                    disabled
                    type="radio"
                    name="assessment[{{ $data->id }}]"
                    value="berwibawa"
                    @if(old('assessment',  optional($data)->assessment ) == 'berwibawa') checked @endif
                />
                <label class="form-check-label">
                Syarikat Berwibawa
                </label>
            </div>
            <div class="form-check">
                <input
                    class="form-check-input @error('assessment') is-invalid @enderror"
                    disabled
                    type="radio"
                    name="assessment[{{ $data->id }}]"
                    value="berupaya"
                    @if(old('assessment',  optional($data)->assessment) == 'berupaya') checked @endif
                />
                <label class="form-check-label">
                Syarikat Berupaya
                </label>
            </div>
            <div class="form-check">
                <input
                    class="form-check-input @error('assessment') is-invalid @enderror"
                    disabled
                    type="radio"
                    name="assessment[{{ $data->id }}]"
                    value="baharu"
                    @if(old('assessment',  optional($data)->assessment) == 'baharu') checked @endif
                />
                <label class="form-check-label">
                Syarikat Baharu
                </label>
            </div>

            @error('assessment')
              <input type="hidden" class="form-control @error('assessment') is-invalid @enderror"  />
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <hr />

        <div class="form-group">
            <h5>Menepati <i>Need Statement</i> ?</h5>
            <div class="form-check">
                <input
                    class="form-check-input @error('need_statement_comply') is-invalid @enderror"
                    disabled
                    type="radio"
                    name="need_statement_comply[{{ $data->id }}]"
                    value="1"
                    @if(old('need_statement_comply',  optional($data)->need_statement_comply) == 1) checked @endif
                    />
                <label class="form-check-label">
                  Ya
                </label>
            </div>
            <div class="form-check">
                <input
                    class="form-check-input @error('need_statement_comply') is-invalid @enderror"
                    disabled
                    type="radio"
                    name="need_statement_comply[{{ $data->id }}]"
                    value="0"
                    @if(old('need_statement_comply',  optional($data)->need_statement_comply) == 0) checked @endif
                    />
                <label class="form-check-label">
                  Tidak
                </label>
            </div>
            @error('need_statement_comply')
            <input  type="hidden" class="form-control @error('assessment') is-invalid @enderror"  />
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
            @enderror
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
                //$scores = ['tajuk','sinopsis','idea_dan_subjek','lengkap','menepati_keperluan_asas'];
                //$scores = ['tajuk','sinopsis','idea_dan_subjek','lengkap'];

                $scores = [
                    'TAJUK' => 'tajuk',
                    'SINOPSIS' => 'sinopsis',
                    'IDEA DAN SUBJEK' => 'idea_dan_subjek',
                    'LENGKAP PROPOSAL' => 'lengkap'
                ];

                $formData = null;
                if(!empty($data)) $formData = $data->toArray();
                $i=1;
            @endphp

            @foreach($scores as $key => $score)
            <div class="row mt-3">
                <div class="col-1">{{$i++}}.</div>
                <div class="col-2 text-uppercase">{{$key}}</div>
                <div class="col-1 text-center">
                    <div class="form-check">
                        <input
                            class="form-check-input @error($score . '_status') is-invalid @enderror"
                            disabled
                            type="radio"
                            name="{{ $score }}_status[{{ $data->id }}]"
                            value="1"
                            @if(old( $score . '_status', $formData ? $formData[$score . '_status'] : null  ) == 1 ) checked @endif
                            />
                    </div>
                </div>
                <div class="col-1 text-center">
                    <div class="form-check">
                        <input
                            class="form-check-input @error($score . '_status') is-invalid @enderror"
                            disabled
                            type="radio"
                            name="{{ $score }}_status[{{ $data->id }}]"
                            value="0"
                            @if(old( $score . '_status', $formData ? $formData[$score . '_status'] : null  ) == 0 ) checked @endif
                            />
                    </div>
                </div>
                <div class="col-6">

                        <textarea
                            class="form-control  @error($score . '_message') is-invalid @enderror"
                            disabled
                            name="{{ $score }}_message[{{ $data->id }}]"
                            rows="3">{{ old( $score . '_message', $formData ? $formData[$score . '_message' ] : null) }}</textarea>
                            @error($score . '_message')
                            <input  type="hidden" class="form-control @error($score . '_status') is-invalid @enderror"  />
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-1"></div>
                <div class="col-2"></div>
                <div class="col-2">
                    @error($score . '_status')
                    <input  type="hidden" class="form-control @error($score . '_status') is-invalid @enderror"  />
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-6"></div>
            </div>
            @endforeach
        </div>
        <hr />

        <div class="form-group">
            <h5>Pengesyoran
                @error('syor_status')
                <input  type="hidden" class="form-control @error($score . '_status') is-invalid @enderror"  />
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </h5>
            <div class="row mt-3 mr-3">
                <div class="col pr-3">
                    <div class="row">
                        <div class="form-check">
                            <input
                                class="form-check-input @error('syor_status') is-invalid @enderror"
                                disabled
                                type="radio"
                                name="syor_status[{{ $data->id }}]"
                                value="1"
                                @if(old('syor_status', optional($data)->syor_status) == 1) checked @endif
                                />
                            <label class="form-check-label">
                            Disokong
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <textarea
                            class="form-control  @error('syor_message_true') is-invalid @enderror"
                            disabled
                            name="syor_message_true"
                            rows="5"
                            >{{ old( 'syor_message_true',  optional($data)->syor_message_true) }}</textarea>
                        @error('syor_message_true')
                        <input  type="hidden" class="form-control @error($score . '_status') is-invalid @enderror"  />
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col">
                    <div class="row">
                        <div class="form-check">
                            <input
                                class="form-check-input  @error('syor_status') is-invalid @enderror"
                                disabled
                                type="radio"
                                name="syor_status[{{ $data->id }}]"
                                value="0"
                                @if(old( 'syor_status',  optional($data)->syor_status) == 0) checked @endif
                                />
                            <label class="form-check-label">
                            Tidak disokong
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <textarea
                            class="form-control  @error('syor_message_false') is-invalid @enderror"
                            disabled
                            name="syor_message_false"
                            rows="5"
                        >{{ old( 'syor_message_false',  optional($data)->syor_message_false) }}</textarea>
                        @error('syor_message_false')
                        <input  type="hidden" class="form-control @error($score . '_status') is-invalid @enderror"  />
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

            </div>
        </div>

        <div class="form-group">
            <h5>Ditanda oleh</h5>
            <div class="form-check">
                <input
                class="form-check-input @error('pengesahan_comply') is-invalid @enderror"
                disabled
                type="checkbox"
                name="pengesahan_comply"
                value=1
                @if(old('pengesahan_comply',  optional($data)->pengesahan_comply) == 1) checked @endif
                />
                @error('pengesahan_comply')
                <input  type="hidden" class="form-control @error('pengesahan_comply') is-invalid @enderror"  />
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <label class="form-check-label ml-3">
                Dengan ini saya mengaku keputusan pemarkahan yang telah dibuat adalah sahih dan muktamad

            </label>
        </div>




