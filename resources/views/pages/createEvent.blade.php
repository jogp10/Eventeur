@extends('layouts.app')

@section('title', '- Create Event')

@section('content')
<div class="container-md">
    <!-- header create event -->
    <div class="row">
        <div class="col">
            <h1 class="text-center m-3">Create Event</h1>
        </div>
    </div>
    <!-- form to create event -->
    <div class="m-2">
        <form action="{{ route('storeEvent') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-3">
                <label for="name">Event Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter event name" required>
            </div>
            <div class="form-group mb-4 mt-4">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="10" placeholder="Enter event description" required></textarea>
            </div>
            <div class="form-group mb-3">
                <label for="location">Location</label>
                <input type="text" class="form-control" id="location" name="location" placeholder="Enter event location" required>
            </div>
            <div class="form-group mb-3">
                <label for="start_date">Start Date</label>
                <input type="date" class="form-control" id="start_date" name="start_date" placeholder="Enter event start date" required>
            </div>
            <div class="form-group mb-3">
                <label for="end_date">End Date</label>
                <input type="date" class="form-control" id="end_date" name="end_date" placeholder="Enter event end date" required>
            </div>
            <div class="form-group mb-3">
                <label for="capacity">Capacity</label>
                <input type="number" class="form-control" id="capacity" name="capacity" placeholder="Enter event capacity" required>
            </div>
            <div class="form-group mb-3">
                <label for="privacy">Privacy</label>
                <select class="form-control" id="privacy" name="privacy" required>
                    <option value="Public">Public</option>
                    <option value="Private">Private</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="ticket">Ticket</label>
                <select class="form-control" id="ticket" name="ticket">
                    <option value="Free">Free</option>
                    <option value="Paid">Paid</option>
                </select>
            </div>
            <!-- Ticket price -->
            <div class="form-group mb-3">
                <label for="price">Price</label>
                <input type="number" class="form-control" id="price" name="price" placeholder="Enter ticket price">
            </div>
            <div class="form-group mb-3">
                <label for="image">Image</label>
                <input type="file" class="form-control-file" id="image" name="image">
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>

</div>
@endsection