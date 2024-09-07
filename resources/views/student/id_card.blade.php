<x-embed-layout>
    @section('content')
        <div class="mt-4">
            <object class="rounded-md" data="{{ route('idcard') }}" type="application/pdf" width="100%" height="600px">
                <iframe src="{{ route('idcard') }}" width="100%" height="600px">
                    <p>This browser does not support PDFs. Please download the PDF to view it: <a
                            href="{{ route('idcard') }}">Download PDF</a>.</p>
                </iframe>
            </object>
        </div>
    @endsection
</x-embed-layout>
