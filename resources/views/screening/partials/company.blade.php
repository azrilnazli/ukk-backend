


        {{-- <div class="card-body">
            <span class="badge badge-dark text-uppercase">{{ str_replace('_',' ',$field)}}</span>
            <div class="alert alert-light">
                <span class="lead">{{ $tenderSubmission->$field }}</span>
            </div>
        </div> --}}


     <div class="card-body">
        <span class="badge badge-dark text-uppercase">company profile</span>
        <div class="alert alert-light">
            <dl class="row">
                <dt class="col-sm-2">Name</dt>
                <dd class="col-sm-9">{{ $company->name  }}</dd>

                <dt class="col-sm-2">Email</dt>
                <dd class="col-sm-9">{{ $company->email  }}</dd>

                <dt class="col-sm-2">Phone</dt>
                <dd class="col-sm-9">{{ $company->phone  }}</dd>

                <dt class="col-sm-2">Address</dt>
                <dd class="col-sm-9">{{ $company->address  }}</dd>

                <dt class="col-sm-2">Postcode</dt>
                <dd class="col-sm-9">{{ $company->postcode  }}</dd>

                <dt class="col-sm-2">City</dt>
                <dd class="col-sm-9">{{ $company->city  }}</dd>

                <dt class="col-sm-2">State</dt>
                <dd class="col-sm-9">{{ $company->states   }}</dd>

                <dt class="col-sm-2">User ID</dt>
                <dd class="col-sm-9">{{ optional($company->user)->id}}</dd>

                <dt class="col-sm-2">User E-Mail</dt>
                <dd class="col-sm-9">{{ optional($company->user)->email}}</dd>

                <dt class="col-sm-2">Registered On</dt>
                <dd class="col-sm-9">{{ $company->created_at }} ~ <small> {{ $company->created_at->diffForHumans() }}</small></dd>

            </dl>
        </div>
    </div>



    <div class="card-body">
        <span class="badge badge-dark text-uppercase">board of director</span>
        <div class="alert alert-light">
        {!! nl2br( $company->board_of_directors) !!}
        </div>
    </div>

    <div class="card-body">
        <span class="badge badge-dark text-uppercase">company experiences</span>
        <div class="alert alert-light">
        {!! nl2br( $company->experiences) !!}
        </div>
    </div>


    <div class="card-body">
        <span class="badge badge-dark text-uppercase">ssm</span>
        <div class="alert alert-light">
            <dl class="row">
                <dt class="col-sm-2">Registration Number</dt>
                <dd class="col-sm-9">{{ $company->ssm_registration_number }}</dd>
            </dl>
            <dl class="row">
                <dt class="col-sm-2">Expiry Date</dt>
                <dd class="col-sm-9">{{ $company->ssm_expiry_date }}</dd>
            </dl>
            <dl class="row">
                <dt class="col-sm-2">Document</dt>
                <dd class="col-sm-9">
                {!!$company->is_ssm_cert_uploaded ?

                    '<button type="button" class="btn btn-sm    btn-primary" data-toggle="modal" data-target="#ssm_modal">
                        View Document
                    </button>'

                    : '<span class="text-danger">missing document</span>' !!}

                </dd>
            </dl>
        </div>
    </div>



    <div class="card-body">
        <span class="badge badge-dark text-uppercase">mof</span>
        <div class="alert alert-light">
            <dl class="row">
                <dt class="col-sm-2">Registration Number</dt>
                <dd class="col-sm-9">{{ $company->mof_registration_number }}</dd>
            </dl>

            <dl class="row">
                <dt class="col-sm-2">eProlehan Status</dt>
                <dd class="col-sm-9">{!! $company->is_mof_active ?
                '<span class="badge badge-success">Active</span>'
                :
                '<span class="badge badge-danger">Expired</span>'
                !!}</dd>
            </dl>
            <dl class="row">
                <dt class="col-sm-2">Expiry Date</dt>
                <dd class="col-sm-9">{{ $company->mof_expiry_date }}</dd>
            </dl>
            <dl class="row">
                <dt class="col-sm-2">Document</dt>
                <dd class="col-sm-9">
                {!!$company->is_mof_cert_uploaded ?

                    '<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#mof_modal">
                        View Document
                    </button>'

                    : '<span class="text-danger">missing document</span>' !!}

                </dd>
            </dl>
        </div>
    </div>

    <div class="card-body">
        <span class="badge badge-dark text-uppercase">FINAS (FP)</span>
        <div class="alert alert-light"> <dl class="row">
                <dt class="col-sm-2">Registration Number</dt>
                <dd class="col-sm-9">{{ $company->finas_fp_registration_number }}</dd>
            </dl>
            <dl class="row">
                <dt class="col-sm-2">Expiry Date</dt>
                <dd class="col-sm-9">{{ $company->finas_fp_expiry_date }}</dd>
            </dl>
            <dl class="row">
                <dt class="col-sm-2">Document</dt>
                <dd class="col-sm-9">
                {!!$company->is_finas_fp_cert_uploaded ?

                    '<button type="button" class="btn btn-sm    btn-primary" data-toggle="modal" data-target="#finas_fp_modal">
                        View Document
                    </button>'

                    : '<span class="text-danger">missing document</span>' !!}

                </dd>
            </dl>
        </div>
    </div>

    <div class="card-body">
        <span class="badge badge-dark text-uppercase">finas (df)</span>
        <div class="alert alert-light">
            <dl class="row">
                <dt class="col-sm-2">Registration Number</dt>
                <dd class="col-sm-9">{{ $company->finas_fd_registration_number }}</dd>
            </dl>
            <dl class="row">
                <dt class="col-sm-2">Expiry Date</dt>
                <dd class="col-sm-9">{{ $company->finas_fd_expiry_date }}</dd>
            </dl>
            <dl class="row">
                <dt class="col-sm-2">Document</dt>
                <dd class="col-sm-9">
                {!!$company->is_finas_fd_cert_uploaded ?

                    '<button type="button" class="btn btn-sm    btn-primary" data-toggle="modal" data-target="#finas_fd_modal">
                        View Document
                    </button>'

                    : '<span class="text-danger">missing document</span>' !!}

                </dd>
            </dl>
        </div>
    </div>

    <div class="card-body">
        <span class="badge badge-dark text-uppercase">kkmm syndicated</span>
        <div class="alert alert-light">
            <dl class="row">
                <dt class="col-sm-2">Registration Number</dt>
                <dd class="col-sm-9">{{ $company->kkmm_syndicated_registration_number }}</dd>
            </dl>
            <dl class="row">
                <dt class="col-sm-2">Expiry Date</dt>
                <dd class="col-sm-9">{{ $company->kkmm_syndicated_expiry_date }}</dd>
            </dl>
            <dl class="row">
                <dt class="col-sm-2">Document</dt>
                <dd class="col-sm-9">
                {!!$company->is_kkmm_syndicated_cert_uploaded ?

                    '<button type="button" class="btn btn-sm    btn-primary" data-toggle="modal" data-target="#kkmm_syndicated_modal">
                        View Document
                    </button>'

                    : '<span class="text-danger">missing document</span>' !!}

                </dd>
            </dl>
        </div>
    </div>

    <div class="card-body">
        <span class="badge badge-dark text-uppercase">kkmm (swasta)</span>
        <div class="alert alert-light">
            <dl class="row">
                <dt class="col-sm-2">Registration Number</dt>
                <dd class="col-sm-9">{{ $company->kkmm_swasta_registration_number }}</dd>
            </dl>
            <dl class="row">
                <dt class="col-sm-2">Expiry Date</dt>
                <dd class="col-sm-9">{{ $company->kkmm_swasta_expiry_date }}</dd>
            </dl>
            <dl class="row">
                <dt class="col-sm-2">Document</dt>
                <dd class="col-sm-9">
                {!!$company->is_kkmm_swasta_cert_uploaded ?

                    '<button type="button" class="btn btn-sm    btn-primary" data-toggle="modal" data-target="#kkmm_swasta_modal">
                        View Document
                    </button>'

                    : '<span class="text-danger">missing document</span>' !!}

                </dd>
            </dl>
        </div>
    </div>

    <div class="card-body">
        <span class="badge badge-dark text-uppercase">bumiputera status</span>
        <div class="alert alert-light">
            <dl class="row">
                <dt class="col-sm-2">Registration Number</dt>
                <dd class="col-sm-9">{{ $company->bumiputera_registration_number }}</dd>
            </dl>
            <dl class="row">
                <dt class="col-sm-2">Expiry Date</dt>
                <dd class="col-sm-9">{{ $company->bumiputera_expiry_date }}</dd>
            </dl>
            <dl class="row">
                <dt class="col-sm-2">Document</dt>
                <dd class="col-sm-9">
                {!!$company->is_bumiputera_cert_uploaded ?

                    '<button type="button" class="btn btn-sm    btn-primary" data-toggle="modal" data-target="#bumiputera_modal">
                        View Document
                    </button>'

                    : '<span class="text-danger">missing document</span>' !!}

                </dd>
            </dl>
        </div>
    </div>

    <div class="card-body">
        <span class="badge badge-dark text-uppercase">banking informations</span>
        <div class="alert alert-light">
            <dl class="row">
                <dt class="col-sm-2">Account Number</dt>
                <dd class="col-sm-9">{{ $company->bank_account_number }}</dd>
            </dl>
            <dl class="row">
                <dt class="col-sm-2">Statement Start Date</dt>
                <dd class="col-sm-9">{{ $company->bank_statement_date_start }}</dd>
            </dl>
            <dl class="row">
                <dt class="col-sm-2">Statement End Date</dt>
                <dd class="col-sm-9">{{ $company->bank_statement_date_end }}</dd>
            </dl>
            <dl class="row">
                <dt class="col-sm-2">Document</dt>
                <dd class="col-sm-9">
                {!!$company->is_bank_cert_uploaded ?

                    '<button type="button" class="btn btn-sm    btn-primary" data-toggle="modal" data-target="#bank_modal">
                        View Document
                    </button>'

                    : '<span class="text-danger">missing document</span>' !!}

                </dd>
            </dl>
        </div>
    </div>

    <div class="card-body">
        <span class="badge badge-dark text-uppercase">credit facility</span>
        <div class="alert alert-light">

            <dl class="row">
                <dt class="col-sm-2">Document</dt>
                <dd class="col-sm-9">
                {!!$company->is_credit_cert_uploaded ?

                    '<button type="button" class="btn btn-sm    btn-primary" data-toggle="modal" data-target="#credit_modal">
                        View Document
                    </button>'

                    : '<span class="text-danger">missing document</span>' !!}

                </dd>
            </dl>
        </div>
    </div>

    <div class="card-body">
        <span class="badge badge-dark text-uppercase">authorization letter</span>
        <div class="alert alert-light">

            <dl class="row">
                <dt class="col-sm-2">Document</dt>
                <dd class="col-sm-9">
                {!!$company->is_authorization_letter_cert_uploaded ?

                    '<button type="button" class="btn btn-sm    btn-primary" data-toggle="modal" data-target="#authorization_letter_modal">
                        View Document
                    </button>'

                    : '<span class="text-danger">missing document</span>' !!}

                </dd>
            </dl>
        </div>
    </div>
    <div class="card-body">
        <span class="badge badge-dark text-uppercase">official company letter</span>
        <div class="alert alert-light">
            <dl class="row">
                <dt class="col-sm-2">Document</dt>
                <dd class="col-sm-9">
                {!!$company->is_official_company_letter_cert_uploaded ?

                    '<button type="button" class="btn btn-sm    btn-primary" data-toggle="modal" data-target="#official_company_letter_modal">
                        View Document
                    </button>'

                    : '<span class="text-danger">missing document</span>' !!}

                </dd>
            </dl>
        </div>
    </div>

    @foreach($company->documents as $key => $document)
    <!-- Modal -->
    <div class="modal fade" id="{{$document}}_modal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase">{{ $document }} Document</h5>
                <button type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div style="height:500px" id="{{$document}}_cert"></div>
                <script>PDFObject.embed("/storage/companies/{{$company->id}}/{{$document}}_cert.pdf", "#{{$document}}_cert");</script>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

            </div>
            </div>
        </div>
    </div>


    @endforeach


    <pre>
        List of documents
        -----------------
        @foreach($company->documents as $key => $document) - <a target="_blank" href="/storage/companies/{{$company->id}}/{{$document}}_cert.pdf">{{$document}}_cert.pdf</a>
        @endforeach
    </pre>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.7/pdfobject.min.js" integrity="sha512-g16L6hyoieygYYZrtuzScNFXrrbJo/lj9+1AYsw+0CYYYZ6lx5J3x9Yyzsm+D37/7jMIGh0fDqdvyYkNWbuYuA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

