<?php


// Home
\App\Http\Controllers\Home\HomeController::routes();

// Auth
Auth::routes();

// Roles
\App\Http\Controllers\User\UserRoleController::routes();

// Permissions
\App\Http\Controllers\User\PermissionController::routes();

// CompanyApproval
\App\Http\Controllers\Company\CompanyApprovalController::routes();

// Content
\App\Http\Controllers\Content\ContentController::routes();

// TenderDetail
\App\Http\Controllers\Tender\TenderDetailController::routes();

// TenderRequirement
\App\Http\Controllers\Tender\TenderRequirementController::routes();

// TenderLanguage
\App\Http\Controllers\Tender\TenderLanguageController::routes();

// TenderCategory
\App\Http\Controllers\Tender\TenderCategoryController::routes();

// Profile
\App\Http\Controllers\Profile\ProfileController::routes();

// User
\App\Http\Controllers\User\UserController::routes();

// Company
\App\Http\Controllers\Company\CompanyController::routes();

// Tender
\App\Http\Controllers\Tender\TenderController::routes();

// TenderSubmission
\App\Http\Controllers\Tender\TenderSubmissionController::routes();

// Scoring
\App\Http\Controllers\JSPD\ScoringController::routes();

// Signer
\App\Http\Controllers\JSPD\SignerController::routes();

// JspdAdmin
\App\Http\Controllers\JSPD\JspdAdminController::routes();

// Video
\App\Http\Controllers\Video\VideoController::routes();

// PitchingSigner
\App\Http\Controllers\Pitching\SignerController::routes();

// PitchingScoring
\App\Http\Controllers\Pitching\ScoringController::routes();

// PitchingVerification
\App\Http\Controllers\Pitching\VerificationController::routes();

// PitchingApproval
\App\Http\Controllers\Pitching\ApprovalController::routes();




