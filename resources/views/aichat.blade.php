
@extends('layout')

@section('scripts')
    @vite(['resources/js/aichat.js'])
@endsection

@section('content')
    <div class="max-w-5xl mx-auto py-6 px-4">

        <div class="flex flex-col h-[90vh] overflow-hidden rounded-3xl
                bg-white border border-slate-200 shadow-xl">

            {{-- Header --}}
            <div class="flex items-center justify-between px-6 py-2
                    border-b border-slate-200 bg-white">

                <div class="flex items-center gap-4">

                    <div class="w-11 h-11 rounded-2xl
                            bg-linear-to-r from-blue-600 to-indigo-600
                            flex items-center justify-center text-white shadow-md">
                        ✨
                    </div>

                    <div>
                        <h2 class="text-lg font-semibold text-slate-800">
                            AI Assistant
                        </h2>

                        <p class="text-sm text-slate-500">
                            Intelligent conversations powered by AI
                        </p>
                    </div>

                </div>

                <div class="flex items-center gap-2 px-3 py-1.5 rounded-full
                        bg-emerald-50 border border-emerald-100">

                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>

                    <span class="text-xs font-medium text-emerald-700">
                    Online
                </span>

                </div>

            </div>

            {{-- Messages --}}
            <div id="userMessageBox"
                 class="flex-1 overflow-y-auto px-6 py-8
                    bg-linear-to-b from-slate-50 via-white to-slate-50">

            </div>

            {{-- Input Area --}}
            <div class="border-t border-slate-200 bg-white p-4">

                <form method="POST"
                      action="{{ route('admin.ai-chat.continue') }}"
                      id="form">

                    @csrf

                    <div class="flex items-end gap-3">

                        <div class="flex-1">

                        <textarea
                            id="prompt"
                            name="prompt"
                            rows="2"
                            style="resize:none"
                            placeholder="Message AI Assistant..."
                            class="w-full rounded-2xl
                                   border border-slate-200
                                   bg-slate-50
                                   px-2 py-3
                                   text-slate-700
                                   placeholder:text-slate-400
                                   focus:border-blue-500
                                   focus:ring-4
                                   focus:ring-blue-100
                                   outline-none transition"></textarea>

                        </div>

                        <button
                            type="submit"
                            class="w-12 h-12 rounded-2xl
                               bg-linear-to-r
                               from-blue-600
                               to-indigo-600
                               hover:from-blue-700
                               hover:to-indigo-700
                               text-white
                               flex items-center justify-center
                               shadow-lg
                               hover:scale-105
                               transition-all duration-200">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-5 h-5"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor">

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 12h14M13 5l7 7-7 7"/>

                            </svg>

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
@endsection

