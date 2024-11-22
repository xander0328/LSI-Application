@extends('layouts.website')
@section('content')
    <div x-data="updates" class="p-8">
        <div class="flex items-center justify-between mb-6">
            <span class="text-4xl font-bold">
                UPDATES
            </span>
            <span>
                <button>Refresh</button>
                <a href="/"
                    class="flex items-center px-2 py-1 bg-gray-200 rounded-full dark:bg-gray-100 hover:text-sky-500">
                    <span class="w-4 h-4">
                        <img class="me-2" width="48" height="48" src="https://img.icons8.com/fluency/48/back.png"
                            alt="back" />
                    </span>
                    <span>
                        Back
                    </span>
                </a>
            </span>
        </div>
        <div class="flex flex-row">

        </div>
    </div>
    <script>
        function updates() {
            return {
                updates: null,
                retrieveUpdates() {

                }
            }
        }
    </script>
@endsection
