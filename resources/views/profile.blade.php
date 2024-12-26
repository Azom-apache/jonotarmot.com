@extends('layouts.app')
@section('content')
<style>
.upload-icon {
    position: absolute;
    bottom: 15px;
    right: 25px;
    background-color: white;
    border: 1px solid #ccc;
    border-radius: 50%;
    padding: 6px;
    font-size: 20px;
    color: #555;
    z-index: 3; 
    width: 30px;
    height: 30px;
    display: flex;
    justify-content: center;
    align-items: center;
}


</style>
<div class="row">
@php
    $currentColor = 'bg-custom2'; // Set the current color to pink
@endphp
<div class="col-lg-3 col-md-4 col-sm-6 mt-4 mb-4">
    <div class="card shadow d-flex flex-column justify-content-between align-items-center custom-border border-{{ $currentColor }}" style="border-radius: 10px !important; position: relative;">
        <div class="position-relative w-100" style="height: 250px; o
        flow: hidden;">
            <div class="position-absolute top-0 start-0 w-100 h-30 {{ $currentColor }}"></div>
            <div class="position-absolute bottom-0 start-0 w-100 h-70 bg-white"></div>
            <div class="position-absolute top-50 start-50 translate-middle text-center" style="z-index: 1;">
                <img src="{{ asset($user->profile_pic ? 'images/users/' . $user->profile_pic : 'images/users/avatar.jpg') }}" 
                     class="rounded-circle profile-image" 
                     height="200px" 
                     width="200px" 
                     style="position: relative; z-index: 2;">
                <label for="profilePicUpload" class="upload-icon">
                    <i class="fas fa-upload"></i>
                </label>
                <input type="file" id="profilePicUpload" name="profile_pic" style="display: none;">
            </div>
        </div>
        <div class="text-center mb-2">
            <h5 class="card-title">{{$user->first_name}} {{$user->last_name}}</h5>
        </div>
        <div class="text-center mb-3">
            <label for="additional_information">{{ translate('Bio') }}</label>
            <p class="text-warning" style="font-size: 13px;">{{$user->about_me}}</p>
        </div>
    </div>
</div>

<div class="col-lg-9 col-md-4 col-sm-9 mt-4 mb-4">
<form method="POST" action="{{ route('user.update') }}" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-4 mb-3">
            <label for="first_name" class="mb-1">{{ translate('First Name') }}</label>
            <input type="text" id="first_name" name="first_name" class="form-control" value="{{ $user->first_name }}" required>
        </div>
        <div class="col-md-4 mb-3">
            <label for="last_name" class="mb-1">{{ translate('Last Name') }}</label>
            <input type="text" id="last_name" name="last_name" class="form-control" value="{{ $user->last_name }}" required>
        </div>
        <div class="col-md-4 mb-3">
            <label for="gender" class="mb-1">{{ translate('Gender') }}</label>
            <select id="gender" name="gender" class="form-control">
                <option value="male" {{ $user->gender === 'male' ? 'selected' : '' }}>{{ translate('Male') }}</option>
                <option value="female" {{ $user->gender === 'female' ? 'selected' : '' }}>{{ translate('Female') }}</option>
                <option value="female" {{ $user->gender === 'others' ? 'selected' : '' }}>{{ translate('Others') }}</option>
            </select>
        </div>
    </div>
    <div class="row" >
        <div class="col-md-4 mb-3">
            <label for="country" class="mb-1">{{ translate('Country') }}</label>
            <select multiple id="js--country-multi-select"  name="country[]" data-placeholder="Add origin Countries" class="form-control">
        @foreach($countries as $country)
        <option value="{{ $country->id }}" {{ in_array($country->id, explode(',', $user->country)) ? 'selected' : '' }}>
            {{ $country->name }}
        </option>
        @endforeach
    </select>
        </div>
        <div class="col-md-4 mb-3">
            <label for="language" class="mb-1">{{ translate('Language') }}</label>
            <select multiple id="js--language-multi-select"  name="language[]" data-placeholder="Add Languages" class="form-control">

            @foreach($languages as $language)
        <option value="{{ $language->id }}" {{ in_array($language->id, explode(',', $user->language)) ? 'selected' : '' }}>
            {{ $language->name }}
        </option>
        @endforeach
            </select>
        </div>
        <div class="col-md-4 mb-3">
            <label for="country" class="mb-1">{{ translate('City') }}</label>
            <input type="text" id="address" name="city" class="form-control" value="{{ $user->city }}" placeholder="Enter your city">
        </div>
    </div>
    <div class="row">
    <div class="col-md-4 mb-3">
            <label for="address" class="mb-1">{{ translate('Address') }}</label>
            <input type="text" id="address" name="address" class="form-control" value="{{ $user->address }}">
        </div>
        <div class="col-md-4 mb-3">
            <label for="postal_code" class="mb-1">{{ translate('Postal code') }}</label>
            <input type="text" id="postal_code" name="postal_code" class="form-control" value="{{ $user->postal_code }}">
        </div>
        <div class="col-md-4 mb-3">
            <label for="phone" class="mb-1">{{ translate('Date of Birth') }}</label>
            <input type="text" id="age" name="age" class="form-control" value="{{ \Carbon\Carbon::parse($user->age)->format('d.m.Y') }}
">
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mb-3">
            <label for="phone" class="mb-1">{{ translate('Phone') }}</label>
            <input type="text" id="phone" name="phone" class="form-control" value="{{ $user->phone }}">
        </div>

        <div class="col-md-4 mb-3">
        <label for="professional_situation">{{ translate('Professional Status') }}</label>
        <select class="form-control" id="professional_situation" name="professional_situation">
            <option value="">Professional Status</option>
            <option value="student" {{ $user->professional_situation == 'student' ? 'selected' : '' }}>Student</option>
            <option value="employee" {{ $user->professional_situation == 'employee' ? 'selected' : '' }}>Employee</option>
            <option value="self-employed" {{ $user->professional_situation == 'self-employed' ? 'selected' : '' }}>Self-Employed</option>
            <option value="unemployed" {{ $user->professional_situation == 'unemployed' ? 'selected' : '' }}>Unemployed</option>
        </select>
    </div>
    <div class="col-md-4 mb-3">
            <label for="occupation">{{ translate('Occupation') }}</label>
            <input type="text" class="form-control" id="occupation" name="occupation" value="{{ $user->occupation }}">
        </div>
    </div>
    <div class="row">
    <div class="col-md-4 mb-3">
    <label for="education_level">{{ translate('Education Level Completed') }}</label>
    <select class="form-control" id="education_level" name="education_level">
        <option value="">Select Education</option>
        <option value="high_school" {{ $user->education_level == 'high_school' ? 'selected' : '' }}>High School</option>
        <option value="associate_degree" {{ $user->education_level == 'associate_degree' ? 'selected' : '' }}>Associate's Degree</option>
        <option value="bachelor_degree" {{ $user->education_level == 'bachelor_degree' ? 'selected' : '' }}>Bachelor's Degree</option>
        <option value="master_degree" {{ $user->education_level == 'master_degree' ? 'selected' : '' }}>Master's Degree</option>
        <option value="doctorate" {{ $user->education_level == 'doctorate' ? 'selected' : '' }}>Doctorate</option>
    </select>
</div>

<div class="col-md-4 mb-3">
    <label for="music_genre">{{ translate('Favorite Genre of Music') }}</label>
    <select class="form-control" id="music_genre" name="music_genre">
        <option value="">Select Music</option>
        <option value="classic_music" {{ $user->music_genre == 'Classic_music' ? 'selected' : '' }}>Classic music</option>
        <option value="electronic_music" {{ $user->music_genre == 'electronic_music' ? 'selected' : '' }}>Electronic music</option>
        <option value="rock" {{ $user->music_genre == 'rock' ? 'selected' : '' }}>Rock</option>
        <option value="pop" {{ $user->music_genre == 'pop' ? 'selected' : '' }}>Pop</option>
        <option value="hip_hop" {{ $user->music_genre == 'hip_hop' ? 'selected' : '' }}>Hip-Hop</option>
        <option value="jazz" {{ $user->music_genre == 'jazz' ? 'selected' : '' }}>Jazz</option>
        <option value="reggae" {{ $user->music_genre == 'reggae' ? 'selected' : '' }}>Reggae</option>
        <option value="world_music" {{ $user->music_genre == 'world_music' ? 'selected' : '' }}>World music</option>
    </select>
</div>
            
<div class="col-md-4 mb-3">
    <label for="film_series_preference">{{ translate('Types of Films or Series You Usually Watch') }}</label>
    <select class="form-control" id="film_series_preference" name="film_series_preference">
        <option value="animation" {{ $user->film_series_preference == 'animation' ? 'selected' : '' }}>Animation</option>
        <option value="biopic" {{ $user->film_series_preference == 'biopic' ? 'selected' : '' }}>Biopic</option>
        <option value="comedy" {{ $user->film_series_preference == 'comedy' ? 'selected' : '' }}>Comedy</option>
        <option value="drama" {{ $user->film_series_preference == 'drama' ? 'selected' : '' }}>Drama</option>
        <option value="thriller" {{ $user->film_series_preference == 'thriller' ? 'selected' : '' }}>Thriller</option>
        <option value="documentary" {{ $user->film_series_preference == 'documentary' ? 'selected' : '' }}>Documentary</option>
        <option value="fantastic" {{ $user->film_series_preference == 'fantastic' ? 'selected' : '' }}>Fantastic/ science-fiction
</option>
        <option value="horror" {{ $user->film_series_preference == 'horror' ? 'selected' : '' }}>Horror</option>
    </select>
</div>
    </div>
    <div class="row">

    <div class="col-md-4 mb-3">
    <label for="artistic_activities">{{ translate('Artistic Activities') }}</label>
    <select class="form-control" id="artistic_activities" name="artistic_activities">
        <option value="music" {{ $user->artistic_activities == 'music' ? 'selected' : '' }}>Music</option>
        <option value="painting" {{ $user->artistic_activities == 'painting' ? 'selected' : '' }}>Painting</option>
        <option value="writing" {{ $user->artistic_activities == 'writing' ? 'selected' : '' }}>Writing</option>
        <option value="photography" {{ $user->artistic_activities == 'photography' ? 'selected' : '' }}>Photography</option>
    </select>
</div>

<div class="col-md-4 mb-3">
    <label for="sport_practiced">{{ translate('Type of Sport Practiced') }}</label>
    <select class="form-control" id="sport_practiced" name="sports">
        <option value="football" {{ $user->sports == 'football' ? 'selected' : '' }}>Football</option>
        <option value="basketball" {{ $user->sports == 'basketball' ? 'selected' : '' }}>Basketball</option>
        <option value="tennis" {{ $user->sports == 'tennis' ? 'selected' : '' }}>Tennis</option>
        <option value="swimming" {{ $user->sports == 'swimming' ? 'selected' : '' }}>Swimming</option>
        <option value="archery" {{ $user->sports == 'archery' ? 'selected' : '' }}>Archery</option>
        <option value="basket" {{ $user->sports == 'basket' ? 'selected' : '' }}>Basket</option>
        <option value="bike" {{ $user->sports == 'bike' ? 'selected' : '' }}>Bike</option>
        <option value="box" {{ $user->sports == 'box' ? 'selected' : '' }}>Box</option>
        <option value="dance" {{ $user->sports == 'dance' ? 'selected' : '' }}>Dance</option>
        <option value="escalation" {{ $user->sports == 'escalation' ? 'selected' : '' }}>Escalation</option>
        <option value="golf" {{ $user->sports == 'golf' ? 'selected' : '' }}>Golf</option>
        <option value="hiking" {{ $user->sports == 'hiking' ? 'selected' : '' }}>Hiking</option>
        <option value="horse riding" {{ $user->sports == 'horse riding' ? 'selected' : '' }}>Horse riding</option>
        <option value="jogging" {{ $user->sports == 'jogging' ? 'selected' : '' }}>Jogging</option>
        <option value="musculature" {{ $user->sports == 'musculature' ? 'selected' : '' }}>Musculature</option>
        <option value="nation" {{ $user->sports == 'nation' ? 'selected' : '' }}>Nation</option>
        <option value="petanque" {{ $user->sports == 'petanque' ? 'selected' : '' }}>Petanque</option>
        <option value="ping pong" {{ $user->sports == 'ping pong' ? 'selected' : '' }}>Ping pong</option>
        <option value="ski" {{ $user->sports == 'ski' ? 'selected' : '' }}>Ski</option>
        <option value="soccer" {{ $user->sports == 'soccer' ? 'selected' : '' }}>Soccer</option>
        <option value="squash" {{ $user->sports == 'squash' ? 'selected' : '' }}>Squash</option>
        <option value="tennis" {{ $user->sports == 'tennis' ? 'selected' : '' }}>Tennis</option>
        <option value="veil" {{ $user->sports == 'veil' ? 'selected' : '' }}>Veil</option>
        <option value="volleyball" {{ $user->sports == 'volleyball' ? 'selected' : '' }}>Volleyball</option>
        <option value="yoga" {{ $user->sports == 'yoga' ? 'selected' : '' }}>Yoga</option>
    </select>
</div>


<div class="col-md-4 mb-3">
    <label for="marital_status">{{ translate('Relationship Status') }}</label>
    <select class="form-control" id="relationship_status" name="relationship_status">
        <option value="single" {{ $user->relationship_status == 'single' ? 'selected' : '' }}>Single</option>
        <option value="in_relationship" {{ $user->relationship_status == 'in_relationship' ? 'selected' : '' }}>In a Relationship</option>
        <option value="married" {{ $user->relationship_status == 'married' ? 'selected' : '' }}>Married</option>
        <option value="divorced" {{ $user->relationship_status == 'divorced' ? 'selected' : '' }}>Divorced</option>
        <option value="widowed" {{ $user->relationship_status == 'widowed' ? 'selected' : '' }}>Widowed</option>
    </select>
</div>
    </div>
    <div class="row">

    <div class="col-md-4 mb-3">
    <label for="children">{{ translate('Do you have children?') }}</label>
    <select class="form-control" id="children" name="children">
        <option value="yes" {{ $user->children == 'yes' ? 'selected' : '' }}>Yes</option>
        <option value="no" {{ $user->children == 'no' ? 'selected' : '' }}>No</option>
    </select>
</div>

<div class="col-md-4 mb-3">
    <label for="number_of_children">{{ translate('If yes, how many children?') }}</label>
    <select class="form-control" id="number_of_children" name="number_of_children">
        <option value="">{{ translate('Select number of children') }}</option>
        @for ($i = 1; $i <= 10; $i++)
            <option value="{{ $i }}" {{ $user->number_of_children == $i ? 'selected' : '' }}>{{ $i }}</option>
        @endfor
    </select>
</div>
<div class="col-md-4 mb-3">
    <label for="religious_affiliation">{{ translate('Religious or Spiritual Affiliation') }}</label>
    <select class="form-control" id="religious_affiliation" name="religious_affiliation">
        <option value="yes" {{ $user->religious_affiliation == 'yes' ? 'selected' : '' }}>Yes</option>
        <option value="no" {{ $user->religious_affiliation == 'no' ? 'selected' : '' }}>No</option>
    </select>
</div>
    </div>
    <div class="row">

    <div class="col-md-4 mb-3">
    <label for="religious_affiliation">{{ translate('Religions') }}</label>
    <select class="form-control" id="religious_affiliation" name="religion_name">
        <option value="buddhism" {{ $user->religion_name == 'buddhism' ? 'selected' : '' }}>Buddhism</option>
        <option value="christianity" {{ $user->religion_name == 'christianity' ? 'selected' : '' }}>Christianity</option>
        <option value="hinduism" {{ $user->religion_name == 'hinduism' ? 'selected' : '' }}>Hinduism</option>
        <option value="islam" {{ $user->religion_name == 'islam' ? 'selected' : '' }}>Islam</option>
        <option value="judaism" {{ $user->religion_name == 'judaism' ? 'selected' : '' }}>Judaism</option>
        <option value="other" {{ $user->religion_name == 'other' ? 'selected' : '' }}>Other</option>
    </select>
</div>
      <div class="col-md-4 mb-3">
      <label for="additional_information">{{ translate('Write About yoruself (Max 500)') }}</label>
      <textarea class="form-control" id="additional_information" name="about_me" placeholder="Additional Information (500 characters max)" rows="3" maxlength="500">{{ $user->about_me }}</textarea>

        </div>
        </div>
    <button type="submit" class="btn btn-primary">{{ translate('Update Profile') }}</button>
</form>

</div>
</div>

@endsection

@section('scripts')
<script src="assets/js/select2.full.min.js"> </script>
<script>
 $(document).ready(function() {
        $('#js--country-multi-select').select2({
            maximumSelectionLength: 4 
        });
        $('#js--city-multi-select').select2({
            maximumSelectionLength: 1 
        });
        $('#js--language-multi-select').select2({
            maximumSelectionLength: 10 
        });


    $('#profilePicUpload').on('change', function() {
        var file = this.files[0];
        if (file) {
            uploadProfilePic(file);
        }
    });
    function uploadProfilePic(file) {
        var formData = new FormData();
        formData.append('profile_pic', file);

        $.ajax({
            url: '{{ route('upload.profile.pic') }}',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    $('.profile-image').attr('src', response.profile_pic_url);
                    // alert('Profile picture updated successfully!');
                } else {
                    alert('Failed to update profile picture.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                // alert('An error occurred while uploading the profile picture.');
            }
        });
    }
});

</script>
@endsection