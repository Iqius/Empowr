<!-- resources/views/chat/chat.blade.php -->
@include('General.header')

<div class="bg-gray-100 flex h-[calc(100vh-64px)] mt-16">
    <!-- Left Sidebar -->
    <div class="w-15 sm:w-64 md:w-80 bg-white border-r border-gray-300 flex flex-col">

        <!-- Search Section (Only visible for admin) -->
        @if($isAdmin)
        <div id="searchContainer" class="p-3 border-b border-gray-300">
            <form action="{{ route('chat.search') }}" method="GET" id="searchForm">
                <div class="relative">
                    <input type="text" name="query" placeholder="Search users" class="w-full bg-gray-100 rounded-full py-2 px-4 pl-10 outline-none" id="searchInput">
                    <i class="fa fa-search absolute left-4 top-3 text-gray-400"></i>
                </div>
            </form>
            <div id="searchResults" class="mt-2 hidden"></div>
        </div>
        @endif

        <!-- Contacts List -->
        <div class="flex-1 overflow-y-auto">
            @if($conversations->count() > 0)
                @foreach($conversations as $conv)
                    <a href="{{ route('chat.show', $conv->other_user_id) }}" 
                    class="flex items-center p-3 hover:bg-gray-100 @if(isset($otherUser) && $conv->other_user_id == $otherUser->id) bg-gray-100 @endif cursor-pointer">
                    
                        <!-- Profile Picture -->
                        <div class="w-12 h-12 rounded-full overflow-hidden relative">
                            @if($conv->otherUser->profile_image)
                                <img src="{{ asset('storage/' . $conv->otherUser->profile_image) }}" 
                                    alt="{{ $conv->otherUser->username }}" 
                                    class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gray-300 flex items-center justify-center text-gray-500">
                                    <i class="fa fa-user"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Info  -->
                        <div class="ml-3 flex-1 hidden sm:block">
                            <div class="flex justify-between items-center">
                                <span class="font-medium">{{ $conv->otherUser->username }}</span>
                                <span class="text-xs text-gray-500">{{ $conv->last_time_message->diffForHumans() }}</span>
                            </div>
                            <div class="flex items-center">
                                @php
                                    $latestMessage = $conv->latestMessage();
                                @endphp
                                
                                @if($latestMessage)
                                    @if($latestMessage->hasAttachment())
                                        @if($latestMessage->isImage())
                                            <span class="text-sm text-gray-500 truncate">Sent an image</span>
                                        @else
                                            <span class="text-sm text-gray-500 truncate">Sent a file</span>
                                        @endif
                                    @else
                                        <span class="text-sm text-gray-500 truncate">{{ Str::limit($latestMessage->message, 25) }}</span>
                                    @endif
                                    
                                    @if($latestMessage->sender_id == Auth::id())
                                        @if($latestMessage->is_read)
                                            <i class="fa fa-check-double text-blue-500 ml-2 text-xs"></i>
                                        @else
                                            <i class="fa fa-check text-gray-400 ml-2 text-xs"></i>
                                        @endif
                                    @endif
                                @else
                                    <span class="text-sm text-gray-500 truncate">Start a conversation</span>
                                @endif
                                
                                @if($conv->unread_count > 0 && (!isset($otherUser) || $conv->other_user_id != $otherUser->id))
                                    <span class="ml-2 bg-blue-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">{{ $conv->unread_count }}</span>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            @else
                <div class="text-center p-5 text-gray-500">
                    <p>No conversations yet</p>
                    <p class="text-sm mt-2">@if($isAdmin) Search for users to start chatting @else Wait for messages or an admin to contact you @endif</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Main Content Area -->
    @if(isset($otherUser))
        <!-- Chat Area when a conversation is selected -->
        <div class="flex-1 flex flex-col">
            <!-- Chat Header -->
            <div class="p-3 bg-white border-b border-gray-300 flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full overflow-hidden">
                        @if($otherUser->profile_image)
                            <img src="{{ asset('storage/' . $otherUser->profile_image) }}" alt="{{ $otherUser->username }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gray-300 flex items-center justify-center text-gray-500">
                                <i class="fa fa-user"></i>
                            </div>
                        @endif
                    </div>
                    <div class="ml-3">
                        <span class="font-medium">{{ $otherUser->username }}</span>
                    </div>
                </div>
            </div>

            <!-- Chat Messages -->
            <div class="flex-1 bg-gray-50 p-4 overflow-y-auto" id="chatMessages">
                <div class="flex flex-col space-y-4">
                    @if($messages->count() > 0)
                        @php
                            $currentDate = null;
                        @endphp
                        
                        @foreach($messages as $message)
                            @php
                                $messageDate = $message->created_at->format('Y-m-d');
                                $showDate = $currentDate !== $messageDate;
                                $currentDate = $messageDate;
                            @endphp
                            
                            @if($showDate)
                                <div class="flex justify-center my-2">
                                    <span class="text-xs bg-gray-200 text-gray-500 py-1 px-3 rounded-full">
                                        @if($message->created_at->isToday())
                                            Today
                                        @elseif($message->created_at->isYesterday())
                                            Yesterday
                                        @else
                                            {{ $message->created_at->format('F j, Y') }}
                                        @endif
                                    </span>
                                </div>
                            @endif
                            
                            @if($message->sender_id === Auth::id())
                                <!-- Sent Message -->
                                <div class="flex items-end justify-end">
                                    <div class="bg-blue-500 text-white rounded-lg py-2 px-4 max-w-md break-words">
                                        @if($message->hasAttachment())
                                            @if($message->isImage())
                                                <a href="{{ $message->getAttachmentUrl() }}" target="_blank" class="block mb-1">
                                                    <img src="{{ $message->getAttachmentUrl() }}" alt="Image" class="max-w-full rounded">
                                                </a>
                                            @else
                                                <a href="{{ $message->getAttachmentUrl() }}" target="_blank" class="flex items-center text-white">
                                                    <i class="fa fa-file mr-2"></i>
                                                    <span>{{ basename($message->attachment) }}</span>
                                                </a>
                                            @endif
                                        @endif
                                        
                                        @if($message->message)
                                            <p>{{ $message->message }}</p>
                                        @endif
                                        
                                        <div class="text-xs text-right mt-1 flex items-center justify-end">
                                            {{ $message->created_at->format('h:i A') }}
                                            @if($message->is_read)
                                                <i class="fa fa-check-double ml-1"></i>
                                            @else
                                                <i class="fa fa-check ml-1"></i>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @else
                                <!-- Received Message -->
                                <div class="flex items-end">
                                    <div class="bg-white rounded-lg py-2 px-4 max-w-md break-words shadow-sm">
                                        @if($message->hasAttachment())
                                            @if($message->isImage())
                                                <a href="{{ $message->getAttachmentUrl() }}" target="_blank" class="block mb-1">
                                                    <img src="{{ $message->getAttachmentUrl() }}" alt="Image" class="max-w-full rounded">
                                                </a>
                                            @else
                                                <a href="{{ $message->getAttachmentUrl() }}" target="_blank" class="flex items-center text-blue-500">
                                                    <i class="fa fa-file mr-2"></i>
                                                    <span>{{ basename($message->attachment) }}</span>
                                                </a>
                                            @endif
                                        @endif
                                        
                                        @if($message->message)
                                            <p>{{ $message->message }}</p>
                                        @endif
                                        
                                        <div class="text-xs text-gray-500 text-right mt-1">
                                            {{ $message->created_at->format('h:i A') }}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <div class="flex justify-center my-4">
                            <span class="text-sm text-gray-500">No messages yet. Start the conversation!</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Message Input -->
            <div class="p-3 bg-white border-t border-gray-300">
                <form action="{{ route('chat.store') }}" method="POST" enctype="multipart/form-data" id="messageForm">
                    @csrf
                    <input type="hidden" name="receiver_id" value="{{ $otherUser->id }}">
                    
                    <div class="flex items-center">
                        <div class="relative">
                            <button type="button" id="attachmentBtn" class="w-10 h-10 rounded-full text-gray-500 flex items-center justify-center hover:bg-gray-100">
                                <i class="fa fa-paperclip"></i>
                            </button>
                            <input type="file" name="attachment" id="attachment" class="hidden">
                        </div>
                        
                        <div class="flex-1 mx-2">
                            <input type="text" name="message" placeholder="Type a message..." class="w-full py-2 px-4 bg-gray-100 rounded-full outline-none" id="messageInput">
                            <div id="attachmentPreview" class="hidden mt-2 p-2 bg-gray-100 rounded flex items-center">
                                <span id="attachmentName" class="text-sm text-gray-700 flex-1 truncate"></span>
                                <button type="button" id="removeAttachment" class="text-gray-500 hover:text-red-500">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                        
                        <button type="submit" class="w-10 h-10 bg-blue-500 text-white rounded-full flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed" id="sendBtn" disabled>
                            <i class="fa fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @else
        <!-- Welcome Screen when no conversation is selected -->
        <div class="flex-1 flex flex-col bg-gray-50 justify-center items-center">
            <div class="text-center p-5">
                <div class="w-20 h-20 mx-auto bg-blue-100 rounded-full flex items-center justify-center text-blue-500 mb-4">
                    <i class="fa fa-comments fa-2x"></i>
                </div>
                <h2 class="text-2xl font-bold mb-2">Welcome to Chat</h2>
                <p class="text-gray-600 mb-4">Select a conversation to start messaging</p>
                
                @if($isAdmin)
                    <p class="text-sm text-gray-500">As an admin, you can search for any user to start a conversation</p>
                @endif
            </div>
        </div>
    @endif
</div>


@include('General.footer')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // AJAX search for admin users
        @if($isAdmin)
        const searchInput = document.getElementById('searchInput');
        const searchResults = document.getElementById('searchResults');
        
        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            
            if (query.length < 2) {
                searchResults.classList.add('hidden');
                return;
            }
            
            fetch(`{{ route('chat.search') }}?query=${query}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        let html = '<div class="bg-white rounded shadow-md">';
                        
                        data.forEach(user => {
                            html += `
                                <a href="{{ route('chat.show', '') }}/${user.id}" class="flex items-center p-2 hover:bg-gray-100">
                                    <div class="w-8 h-8 rounded-full overflow-hidden bg-gray-300 flex items-center justify-center text-gray-500">
                                        ${user.profile_image ? 
                                            `<img src="{{ asset('storage/') }}/${user.profile_image}" class="w-full h-full object-cover">` : 
                                            `<i class="fa fa-user"></i>`}
                                    </div>
                                    <div class="ml-2">
                                        <div class="text-sm font-medium">${user.username}</div>
                                        <div class="text-xs text-gray-500">${user.email}</div>
                                    </div>
                                </a>
                            `;
                        });
                        
                        html += '</div>';
                        searchResults.innerHTML = html;
                        searchResults.classList.remove('hidden');
                    } else {
                        searchResults.innerHTML = '<div class="bg-white p-2 rounded shadow-md text-center text-gray-500">No users found</div>';
                        searchResults.classList.remove('hidden');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
        
        // Hide search results when clicking outside
        document.addEventListener('click', function(event) {
            if (!searchInput.contains(event.target) && !searchResults.contains(event.target)) {
                searchResults.classList.add('hidden');
            }
        });
        @endif

        // Chat functionality when a conversation is selected
        @if(isset($otherUser))
        const chatMessages = document.getElementById('chatMessages');
        const messageInput = document.getElementById('messageInput');
        const sendBtn = document.getElementById('sendBtn');
        const attachmentBtn = document.getElementById('attachmentBtn');
        const attachment = document.getElementById('attachment');
        const attachmentPreview = document.getElementById('attachmentPreview');
        const attachmentName = document.getElementById('attachmentName');
        const removeAttachment = document.getElementById('removeAttachment');
        
        // Scroll to bottom of messages
        chatMessages.scrollTop = chatMessages.scrollHeight;
        
        // Enable/disable send button
        function toggleSendButton() {
            sendBtn.disabled = messageInput.value.trim() === '' && (!attachment.files || attachment.files.length === 0);
        }
        
        messageInput.addEventListener('input', toggleSendButton);
        
        // Handle attachment selection
        attachmentBtn.addEventListener('click', function() {
            attachment.click();
        });
        
        attachment.addEventListener('change', function() {
            if (this.files.length) {
                attachmentName.textContent = this.files[0].name;
                attachmentPreview.classList.remove('hidden');
                sendBtn.disabled = false;
            }
        });
        
        // Remove attachment
        removeAttachment.addEventListener('click', function() {
            attachment.value = '';
            attachmentPreview.classList.add('hidden');
            toggleSendButton();
        });
        
        // Handle form submission
        const messageForm = document.getElementById('messageForm');
        messageForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reset form
                    messageInput.value = '';
                    attachment.value = '';
                    attachmentPreview.classList.add('hidden');
                    toggleSendButton();
                    
                    // Reload the page to show the new message
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
        @endif
    });
</script>