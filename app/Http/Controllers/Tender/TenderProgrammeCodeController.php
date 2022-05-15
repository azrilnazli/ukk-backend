<?php

namespace App\Http\Controllers\Tender;

use App\Models\TenderProgrammeCode;
use App\Http\Requests\Tender\StoreTenderProgrammeCodeRequest;
use App\Http\Requests\Tender\UpdateTenderProgrammeCodeRequest;

class TenderProgrammeCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTenderProgrammeCodeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTenderProgrammeCodeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TenderProgrammeCode  $tenderProgrammeCode
     * @return \Illuminate\Http\Response
     */
    public function show(TenderProgrammeCode $tenderProgrammeCode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TenderProgrammeCode  $tenderProgrammeCode
     * @return \Illuminate\Http\Response
     */
    public function edit(TenderProgrammeCode $tenderProgrammeCode)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTenderProgrammeCodeRequest  $request
     * @param  \App\Models\TenderProgrammeCode  $tenderProgrammeCode
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTenderProgrammeCodeRequest $request, TenderProgrammeCode $tenderProgrammeCode)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TenderProgrammeCode  $tenderProgrammeCode
     * @return \Illuminate\Http\Response
     */
    public function destroy(TenderProgrammeCode $tenderProgrammeCode)
    {
        //
    }
}
