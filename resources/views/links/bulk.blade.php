@extends('layouts.app')

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" rel="stylesheet" />
    <style>
        .dropzone {
            border: 2px dashed #007bff;
            border-radius: .5rem;
            background: #f8f9fa;
            padding: 2rem;
        }

        .dz-message {
            font-size: 1.1rem;
            color: #495057;
        }

        .bulk-container {
            max-width: 600px;
            margin: 4rem auto;
            background: #fff;
            padding: 2.5rem;
            border-radius: .75rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }

        #bulkResult .alert {
            margin-top: 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
    </style>
@endpush

@section('content')
    <div class="bulk-container">
        <h2 class="text-center mb-4">@lang('links.bulk.title')</h2>

        <form action="{{ route('links.bulk.process') }}" class="dropzone" id="bulkDropzone" enctype="multipart/form-data">
            @csrf
            <div class="dz-message">
                {!! trans('links.bulk.dropzone_hint') !!}
            </div>
        </form>

        <div id="bulkResult"></div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>
    <script>
        const tSuccessAll = "@lang('links.bulk.success_all', ['total' => ':total'])";
        const tPartial = "@lang('links.bulk.partial', ['invalid' => ':invalid', 'total' => ':total'])";
        const tError = "@lang('links.bulk.error')";
        const tDownload = "Download file";

        Dropzone.options.bulkDropzone = {
            paramName: "file",
            maxFiles: 1,
            acceptedFiles: ".xlsx",
            init: function() {
                this.on("success", (file, resp) => {
                    let msg, cls;
                    if (resp.invalid === 0) {
                        msg = tSuccessAll.replace(':total', resp.total);
                        cls = 'alert-success';
                    } else {
                        msg = tPartial
                            .replace(':invalid', resp.invalid)
                            .replace(':total', resp.total);
                        cls = 'alert-warning';
                    }

                    document.getElementById('bulkResult').innerHTML =
                        `<div class="alert ${cls}" role="alert">
                 <span>${msg}</span>
                 <a href="${resp.download_url}" download class="btn btn-sm btn-outline-primary">${tDownload}</a>
               </div>`;

                    this.removeAllFiles(true);
                });

                this.on("error", (file, err) => {
                    document.getElementById('bulkResult').innerHTML =
                        `<div class="alert alert-danger" role="alert">${tError}</div>`;
                    this.removeFile(file);
                });
            }
        };
    </script>
@endpush
