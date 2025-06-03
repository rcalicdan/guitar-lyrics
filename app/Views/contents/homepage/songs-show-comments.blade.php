<!-- Comments Section -->
<section class="comments-section mt-5" x-show="true" x-transition:enter="transition ease-out duration-500 delay-400"
    x-transition:enter-start="opacity-0 transform translate-y-4"
    x-transition:enter-end="opacity-100 transform translate-y-0">
    <div class="container">
        <div class="comments-card">
            <h4 class="mb-4">
                <i class="fas fa-comments me-2 text-primary"></i>
                Comments (<span x-text="comments.length"></span>)
            </h4>

            <!-- Comment Form -->
            <div class="comment-form mb-4" x-show="isAuthenticated">
                <form @submit.prevent="submitComment()">
                    <div class="mb-3">
                        <textarea x-model="newComment.content" class="form-control" rows="4"
                            placeholder="Share your thoughts about this song..." :disabled="submittingComment"
                            required></textarea>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <span x-text="newComment.content.length"></span>/1000 characters
                        </small>
                        <button type="submit" class="btn btn-primary"
                            :disabled="submittingComment || !newComment.content.trim()"
                            x-text="submittingComment ? 'Posting...' : 'Post Comment'">
                        </button>
                    </div>
                </form>
            </div>

            <!-- Login Prompt -->
            <div class="alert alert-info" x-show="!isAuthenticated">
                <i class="fas fa-info-circle me-2"></i>
                <a href="{{ route_to('login') }}" class="alert-link">Login</a> to post a comment.
            </div>

            <!-- Comments List -->
            <div class="comments-list" x-show="comments.length > 0">
                <template x-for="comment in comments" :key="comment.id">
                    <div class="comment-item">
                        <!-- Main Comment -->
                        <div class="comment-content">
                            <div class="comment-header">
                                <img :src="comment.user.image" :alt="comment.user.name" class="comment-avatar">
                                <div class="comment-meta">
                                    <strong x-text="comment.user.name"></strong>
                                    <small class="text-muted" x-text="comment.created_at"></small>
                                </div>
                                <div class="comment-actions" x-show="comment.user.id === currentUserId">
                                    <button @click="editComment(comment)" class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button @click="deleteComment(comment.id)" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Comment Text -->
                            <div class="comment-text" x-show="editingCommentId !== comment.id">
                                <p x-text="comment.content"></p>
                            </div>

                            <!-- Edit Form -->
                            <div class="edit-comment-form" x-show="editingCommentId === comment.id">
                                <form @submit.prevent="updateComment(comment)">
                                    <textarea x-model="editCommentContent" class="form-control mb-2" rows="3"
                                        required></textarea>
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                        <button type="button" @click="cancelEdit()"
                                            class="btn btn-sm btn-secondary">Cancel</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Reply Button -->
                            <div class="comment-footer">
                                <button @click="toggleReplyForm(comment.id)"
                                    class="btn btn-sm btn-link text-decoration-none">
                                    <i class="fas fa-reply me-1"></i>Reply
                                </button>
                            </div>
                        </div>

                        <!-- Reply Form -->
                        <div class="reply-form" x-show="replyingToId === comment.id">
                            <form @submit.prevent="submitReply(comment.id)">
                                <div class="mb-2">
                                    <textarea x-model="replyContent" class="form-control" rows="3"
                                        placeholder="Write a reply..." required></textarea>
                                </div>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-sm btn-primary">Reply</button>
                                    <button type="button" @click="cancelReply()"
                                        class="btn btn-sm btn-secondary">Cancel</button>
                                </div>
                            </form>
                        </div>

                        <!-- Replies -->
                        <div class="replies" x-show="comment.replies && comment.replies.length > 0">
                            <template x-for="reply in comment.replies" :key="reply.id">
                                <div class="reply-item">
                                    <div class="comment-header">
                                        <img :src="reply.user.image" :alt="reply.user.name" class="comment-avatar">
                                        <div class="comment-meta">
                                            <strong x-text="reply.user.name"></strong>
                                            <small class="text-muted" x-text="reply.created_at"></small>
                                        </div>
                                        <div class="comment-actions" x-show="reply.user.id === currentUserId">
                                            <button @click="deleteComment(reply.id)"
                                                class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="comment-text">
                                        <p x-text="reply.content"></p>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>

            <!-- No Comments -->
            <div class="text-center py-4" x-show="comments.length === 0">
                <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                <p class="text-muted">No comments yet. Be the first to share your thoughts!</p>
            </div>
        </div>
    </div>
</section>