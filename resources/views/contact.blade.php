@extends('layout.base')

@section('meta_description', '')
@section('meta_title', '')
@section('title')
  Contact
@endsection

@section('content')

    
    <form id="contactForm" action="{{ route('inquiries.store') }}" method="POST">
  @csrf
  <div class="grid">
    <div class="field">
      <label for="name">Name *</label>
      <input id="name" name="name" type="text" required maxlength="100" />
    </div>

    <div class="field">
      <label for="email">Email *</label>
      <input id="email" name="email" type="email" required maxlength="150" />
    </div>

    <div class="field">
      <label for="mobile">Mobile *</label>
      <input id="mobile" name="mobile" type="tel" required pattern="\d{10}" maxlength="10" />
    </div>

    <div class="field fullwidth">
      <label for="description">Description</label>
      <textarea id="description" name="description"></textarea>
    </div>
  </div>
  <div class="actions">
    <button type="submit" class="btn btn-primary">Send Inquiry</button>
  </div>
</form>

    
@endsection