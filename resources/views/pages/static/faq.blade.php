@extends('layouts.app')

@section('title', 'FAQs')
@section('content')
<div class="container-md align-items-center">
    <div class="col" style="text-align:center;">
        <h1 class="fs-1">FREQUENTLY ASKED QUESTIONS</h1>
        <div>
            <div class="container text-center pb-4">
                <div class="d-flex flex-row justify-content-center align-items-center">
                    <span class="fs-2 me-3">1. What is Eventeur?</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16" style="display:block" onclick="toggleDescription('1', this)">
                        <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" cwidth="16" height="16" fill="currentColor" class="bi bi-chevron-up" viewBox="0 0 16 16" style="display:none" onclick="toggleDescription('1', this)">
                        <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z" />
                    </svg>
                </div>
                <div class="row pt-2" style="display: none;">
                    <p style="margin-bottom:0.5rem">
                        Eventeur is a web platform for event management, allowing users to smooth their schedules and never miss any good event opportunities.
                    </p>
                </div>
            </div>
            <div class="container text-center pb-4">
                <div class="d-flex flex-row justify-content-center align-items-center">
                    <span class="fs-2 me-3">2. The event was canceled, and now?</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16" style="display:block" onclick="toggleDescription('2', this)">
                        <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-up" viewBox="0 0 16 16" style="display:none" onclick="toggleDescription('2', this)">
                        <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z" />
                    </svg>
                </div>
                <div class="row  pt-2" style="display: none;">
                    <p style="margin-bottom:0.5rem">
                        If the event was canceled, you will be notified by email and the event will be removed from your schedule.
                    </p>
                </div>
            </div>
            <div class="container text-center pb-4">
                <div class="d-flex flex-row justify-content-center align-items-center">
                    <span class="fs-2 me-3">3. I want to report an event, what should I do?</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16" style="display:block" onclick="toggleDescription('3', this)">
                        <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-up" viewBox="0 0 16 16" style="display:none" onclick="toggleDescription('3', this)">
                        <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z" />
                    </svg>
                </div>
                <div class="row  pt-2" style="display: none;">
                    <p>
                        If you want to report an event, you can do it by clicking on the "Report" button on the event page.
                    </p>
                </div>
            </div>
            <div class="container text-center pb-4">
                <div class="d-flex flex-row justify-content-center align-items-center">
                    <span class="fs-2 me-3">4. Can anyone create an event</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="col-sm-1" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16" style="display:block" onclick="toggleDescription('4', this)">
                        <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" class="col-sm-1" width="16" height="16" fill="currentColor" class="bi bi-chevron-up" viewBox="0 0 16 16" style="display:none" onclick="toggleDescription('4', this)">
                        <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z" />
                    </svg>
                </div>
                <div class="row  pt-2" style="display: none;">
                    <p style="margin-bottom:0.5rem">
                        Yes, anyone can create an event, but it will be reviewed by our team before being published.
                    </p>
                </div>
            </div>
            <div class="container text-center pb-4">
                <div class="d-flex flex-row justify-content-center align-items-center">
                    <span class="fs-2 me-3">5. I bought the wrong ticker, can I refund it?</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="col-sm-1" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16" style="display:block" onclick="toggleDescription('5', this)">
                        <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" class="col-sm-1" width="16" height="16" fill="currentColor" class="bi bi-chevron-up" viewBox="0 0 16 16" style="display:none" onclick="toggleDescription('5', this)">
                        <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z" />
                    </svg>
                </div>
                <div class="row  pt-2" style="display: none;">
                    <p style="margin-bottom:0.5rem">
                        If you bought the wrong ticket, you can refund it by contacting our support team.
                    </p>
                </div>
            </div>
            <div class="container text-center pb-4">
                <div class="d-flex flex-row justify-content-center align-items-center">
                    <span class="fs-2 me-3">6. I got banned! What do I do now?</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="col-sm-1" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16" style="display:block" onclick="toggleDescription('6', this)">
                        <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" class="col-sm-1" width="16" height="16" fill="currentColor" class="bi bi-chevron-up" viewBox="0 0 16 16" style="display:none" onclick="toggleDescription('6', this)">
                        <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z" />
                    </svg>
                </div>
                <div class="row  pt-2" style="display: none;">
                    <p style="margin-bottom:0.5rem">
                        If you got banned, you can contact our support team and we will try to help you.
                    </p>
                </div>
            </div>
            <div class="container text-center pb-4">
                <div class="d-flex flex-row justify-content-center align-items-center">
                    <span class="fs-2 me-3">7. I want to change my username. Do I have to start a new account?</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="col-sm-1" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16" style="display:block" onclick="toggleDescription('7', this)">
                        <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" class="col-sm-1" width="16" height="16" fill="currentColor" class="bi bi-chevron-up" viewBox="0 0 16 16" style="display:none" onclick="toggleDescription('7', this)">
                        <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z" />
                    </svg>
                </div>
                <div class="row  pt-2" style="display: none;">
                    <p style="margin-bottom:0.5rem">
                        No, you can change your username by clicking on the "Edit Profile" button on your profile page.
                    </p>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection