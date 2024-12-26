<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/apps/favicon.ico') }}">
    <title>Poll</title>

    <!-- Fonts and icons -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <link id="pagestyle" href="{{ asset('assets/css/material-dashboard.css?v=3.0.4') }}" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

    <style>
        body {
            background-color: #f7f7f7;
            /* Light gray background for the body */
        }

        .header {
            /* background: url('{{ asset('images/apps/1715081693_663a11dd54806.png') }}') no-repeat center center; */
            background-size: cover;
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
        }
        .poll-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); /* Adjust values as needed */
        }


        .poll-title,
        h4 {
            font-size: 1.5rem;
            color: #475563;
        }

        .poll-option {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .option-label {
            width: 150px;
            text-align: left;
            color: #283441;
            font-size: 1rem;
        }

        .progress-container {
            width: 70%;
            margin-left: 10px;
        }

        .progress {
            background-color: #4d6b8a;
            border-radius: 10px;
            height: 20px;
        }

        .progress-bar {
            background-color: #44051a;
            height: 100%;
            color: white;
            text-align: right;
            padding-right: 10px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1 class="text-warning">Welcome to Jonotar mot</h1>
    </div>
<br>
<section class="poll-container">
    <div class="poll-details" id="poll-details">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <h3 class="text-center">Poll Details</h3>

        <!-- Display the Poll Title -->
        <div class="poll-title text-center mb-4">
            {{ $poll->title }}
        </div>

        <!-- Check if the user has already voted or if the poll is public -->
        @if (!$poll->is_private && isset($totalVotes) && $totalVotes > 0 && $hasVoted)
            <h4 class="text-center mb-3">Poll Results</h4>

            @foreach ($poll->options as $option)
                @php
                    $voteCount = $optionVotes[$option->id]; // Get the total votes for the option
                    $percentage = round(($voteCount / $totalVotes) * 100, 2); // Calculate the percentage
                    
                    // Determine color based on percentage
                    if ($percentage >= 50) {
                        $barColor = 'bg-primary'; // High percentage
                    } elseif ($percentage >= 30) {
                        $barColor = 'bg-warning'; // Medium percentage
                    } elseif ($percentage >= 20) {
                        $barColor = 'bg-success'; // Low percentage
                    } elseif ($percentage >= 10) {
                        $barColor = 'bg-danger'; // Very low percentage
                    } else {
                        $barColor = 'bg-danger'; // Minimal percentage
                    }
                @endphp

                <div class="poll-option mb-3 d-flex align-items-center justify-content-center">
                    <!-- Option Label -->
                    <label class="option-label mr-3">{{ $option->option }}</label>

                    <!-- Progress bar -->
                    <div class="progress-container card" style="flex-grow: 1;">
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar {{ $barColor }}" role="progressbar"
                                style="width: {{ $percentage }}%;" aria-valuenow="{{ $percentage }}"
                                aria-valuemin="0" aria-valuemax="100">
                                <!-- Show percentage and vote count -->
                                {{ $percentage }}% ({{ $voteCount }} votes)
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <!-- Show voting form if the user hasn't voted or results are not public -->
            <form action="{{ route('poll.vote', $poll->id) }}" method="POST" class="text-center">
                @csrf
                @foreach ($poll->options as $option)
                    <div class="poll-option mb-3 d-flex align-items-center justify-content-center">
                        <input type="radio" name="option_id" value="{{ $option->id }}"
                            id="option_{{ $option->id }}" class="mr-2">
                        <label for="option_{{ $option->id }}" class="option-label">{{ $option->option }}</label>
                    </div>
                @endforeach
                <input type="hidden" name="local_ip" id="local_ip" value="">
                <button type="submit" class="btn btn-primary">Submit Vote</button>
            </form>
        @endif
    </div>
</section>



    <!-- Core JS Files -->
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
   <script>
    function getLocalIP(callback) {
        const peerConnection = new RTCPeerConnection();
        peerConnection.createDataChannel('');

        peerConnection.onicecandidate = function (event) {
            if (event && event.candidate && event.candidate.candidate) {
                const candidate = event.candidate.candidate;
                const localIP = candidate.split(' ')[4];  // Extract IP from candidate string
                callback(localIP);
                peerConnection.onicecandidate = () => {};  // Stop after the first candidate
            }
        };

        peerConnection.createOffer().then((offer) => peerConnection.setLocalDescription(offer));
    }

    // When the page is ready, get the local IP and send it via AJAX
    document.addEventListener('DOMContentLoaded', function () {
        getLocalIP(function (localIP) {
            document.getElementById('local_ip').value = localIP;  // Set the local IP in the hidden field

            // Send the local IP via AJAX to the showPollDetails route
            const pollId = {{ $poll->id }};
            const token = '{{ csrf_token() }}';

            fetch(`/poll/${pollId}/update-ip`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({
                    local_ip: localIP
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Local IP sent to server:', data);
            })
            .catch(error => console.error('Error sending local IP:', error));
        });
    });
</script>
    
</body>

</html>
