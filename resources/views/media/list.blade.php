@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Media Gallery for Post #{{ $post_id }}</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($media->isEmpty())
        <p>No media uploaded yet.</p>
    @else
        <div class="row g-4">
            @foreach($media as $item)
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm">
                        {{-- Media Thumbnail with Modal Trigger --}}
                        <a href="#" data-bs-toggle="modal" data-bs-target="#mediaModal{{ $item->id }}">
                            @if($item->media_type === 'image')
                                <img src="{{ asset('storage/' . $item->path) }}"
                                     class="card-img-top img-fluid"
                                     style="object-fit: cover; height: 200px;"
                                     alt="Image preview">
                            @elseif($item->media_type === 'video')
                                <div class="video-thumbnail-overlay">
                                    <video src="{{ asset('storage/' . $item->path) }}"
                                           class="card-img-top img-fluid"
                                           style="object-fit: cover; height: 200px;"
                                           muted></video>
                                    <div class="play-icon-overlay">▶️</div>
                                </div>
                            @endif
                        </a>

                        <div class="card-body d-flex flex-column justify-content-between">
                            <h6 class="card-title">{{ ucfirst($item->media_type) }}</h6>

                            <small class="text-muted d-block mb-2">
                                Uploaded {{ $item->created_at->diffForHumans() }}
                            </small>

                            <div class="d-grid gap-2">
                                {{-- Download --}}
                                <a href="{{ asset('storage/' . $item->path) }}" class="btn btn-outline-primary btn-sm" download>
                                    Download
                                </a>

                                {{-- Edit --}}
                                <a href="#" class="btn btn-outline-secondary btn-sm">
                                    Edit
                                </a>

                                {{-- Delete --}}
                                <form action="#" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this media?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Modal Preview --}}
                <div class="modal fade" id="mediaModal{{ $item->id }}" tabindex="-1" aria-labelledby="mediaModalLabel{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content bg-dark text-white">
                            <div class="modal-header border-0">
                                <h5 class="modal-title" id="mediaModalLabel{{ $item->id }}">
                                    {{ ucfirst($item->media_type) }} Preview
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                @if($item->media_type === 'image')
                                    <img src="{{ asset('storage/' . $item->path) }}"
                                         class="img-fluid rounded"
                                         alt="Image Preview">
                                @elseif($item->media_type === 'video')
                                    {{-- Video Player with Custom Controls --}}
                                    <div class="video-player-container">
                                        <video id="video-player-{{ $item->id }}"
                                               src="{{ asset('storage/' . $item->path) }}"
                                               class="w-100 rounded border"
                                               preload="metadata"
                                               ></video>
                                        <div class="d-flex align-items-center gap-2 mt-2">
                                            <button class="btn btn-sm btn-light play-toggle-btn" data-video-id="{{ $item->id }}">▶️</button>
                                            <input type="range" class="form-range flex-grow-1 scrub-bar" data-video-id="{{ $item->id }}" value="0" step="0.01">
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div>
        <button class="btn btn-primary mt-3" onclick="window.location.href='{{ route('creator.media.create', ['post_id' => $post_id]) }}'">
            Add New Media
        </button>
    </div>

</div>
@endsection

@push('scripts')
<script>
    // Get all video-related modals
    const videoModals = document.querySelectorAll('.modal[id^="mediaModal"]');

    // Attach event listeners to each video modal
    videoModals.forEach(modal => {
        const modalId = modal.id;
        const itemId = modalId.replace('mediaModal', '');

        const videoPlayer = document.getElementById(`video-player-${itemId}`);
        const scrubBar = document.querySelector(`.scrub-bar[data-video-id="${itemId}"]`);
        const playToggleBtn = document.querySelector(`.play-toggle-btn[data-video-id="${itemId}"]`);

        if (videoPlayer && scrubBar && playToggleBtn) {
            // Event listener to update the scrub bar when the video plays
            videoPlayer.addEventListener('timeupdate', () => {
                scrubBar.value = videoPlayer.currentTime;
            });

            // Event listener to seek the video when the scrub bar is moved
            scrubBar.addEventListener('input', () => {
                videoPlayer.currentTime = scrubBar.value;
            });

            // Event listener to set the scrub bar's max value when video metadata is loaded
            videoPlayer.addEventListener('loadedmetadata', () => {
                scrubBar.max = videoPlayer.duration;
            });

            // Event listener to toggle play/pause
            playToggleBtn.addEventListener('click', () => {
                if (videoPlayer.paused) {
                    videoPlayer.play();
                    playToggleBtn.innerHTML = '⏸️';
                } else {
                    videoPlayer.pause();
                    playToggleBtn.innerHTML = '▶️';
                }
            });

            // Event listener to update the button icon when the video pauses on its own
            videoPlayer.addEventListener('pause', () => {
                playToggleBtn.innerHTML = '▶️';
            });

            // Event listener to stop the video when the modal is closed
            modal.addEventListener('hidden.bs.modal', () => {
                videoPlayer.pause();
                videoPlayer.currentTime = 0;
            });
        }
    });
</script>
@endpush