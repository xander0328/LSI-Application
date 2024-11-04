<x-embed-layout>
    @section('content')
        <div class="mt-4">
            <object class="rounded-md"
                data="{{ asset('storage/enrollee_files/' . $diploma->enrollee->course->id . '/' . $diploma->enrollee_id . '/' . $diploma->credential_type . '/' . $diploma->folder . '/' . $diploma->filename) }}"
                type="application/pdf" width="100%" height="600px">
                <iframe
                    src="{{ asset('storage/enrollee_files/' . $diploma->enrollee->course->id . '/' . $diploma->enrollee_id . '/' . $diploma->credential_type . '/' . $diploma->folder . '/' . $diploma->filename) }}"
                    width="100%" height="600px">
                    <p>This browser does not support PDFs. Please download the PDF to view it: <a
                            href="{{ asset('storage/enrollee_files/' . $diploma->enrollee->course->id . '/' . $diploma->enrollee_id . '/' . $diploma->credential_type . '/' . $diploma->folder . '/' . $diploma->filename) }}">Download
                            PDF</a>.</p>
                </iframe>
            </object>
        </div>
    @endsection
</x-embed-layout>
