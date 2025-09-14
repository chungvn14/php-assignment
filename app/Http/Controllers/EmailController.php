<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailRequest;
use App\Http\Requests\EmailRequestUpdate;
use App\Models\Email;
use App\Services\EmailService;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\EmailResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EmailController extends Controller
{
    private EmailService $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    public function index()
{
    $emails = $this->emailService->getAllEmails();
    return EmailResource::collection($emails);
}

public function userIndex(Request $request)
{
    $user = $request->user();
    return $user->emails()->latest()->get(); // nếu User model có relation emails()
}

    public function store(EmailRequest $request): JsonResponse
    {
       \Log::info('Email payload', $request->all());
        $email = $this->emailService->createEmail($request->validated());
        return response()->json(new EmailResource($email), 201);
    }

    public function show(Email $email): JsonResponse
    {
        return response()->json(new EmailResource($email));
    }

    public function update(EmailRequestUpdate $request, Email $email)
{
    $data = $request->validated();

    if ($request->hasFile('attachment')) {
        $data['attachment'] = $request->file('attachment');
    }

    $updated = $this->emailService->updateEmail($email, $data);

    return response()->json(new EmailResource($updated));
}

 public function retry(Email $email): JsonResponse
{
    \Log::info('Retry API called for email ID: '.$email->id.' | email: '.json_encode($email->toArray()));
    $retried = $this->emailService->retryEmail($email);

    return response()->json([
        'message' => 'Email retried successfully',
        'email' => new EmailResource($retried)
    ]);
}

    public function destroy(Email $email): JsonResponse
    {
        $this->emailService->deleteEmail($email);
        return response()->json(['message' => 'Email soft deleted']);
    }
}
