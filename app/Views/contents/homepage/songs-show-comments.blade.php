<!-- Comments Section -->
<section class="comments-section mt-5" x-data="commentManager('{{ $song->slug }}')" x-show="true"
    x-transition:enter="transition ease-out duration-500 delay-400"
    x-transition:enter-start="opacity-0 transform translate-y-4"
    x-transition:enter-end="opacity-100 transform translate-y-0">
    <div class="container">
        <div class="comments-card">
            <h4 class="mb-4">
                <i class="fas fa-comments me-2 text-primary"></i>
                Comments (<span x-text="totalComments"></span>)
            </h4>

            <!-- Comment Form -->
            <div class="comment-form mb-4" x-show="isAuthenticated">
                <form @submit.prevent="submitComment()">
                    <div class="mb-3">
                        <textarea x-model="newComment.content" class="form-control" rows="4"
                            placeholder="Share your thoughts about this song..." :disabled="submittingComment"
                            maxlength="1000" required></textarea>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted" :class="{'text-danger': newComment.content.length > 950}">
                            <span x-text="newComment.content.length"></span>/1000 characters
                        </small>
                        <button type="submit" class="btn btn-primary"
                            :disabled="submittingComment || !newComment.content.trim() || newComment.content.length > 1000">
                            <span x-show="submittingComment">
                                <i class="fas fa-spinner fa-spin me-1"></i>
                                Posting...
                            </span>
                            <span x-show="!submittingComment">
                                <i class="fas fa-paper-plane me-1"></i>
                                Post Comment
                            </span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Login Prompt -->
            <div class="alert alert-info" x-show="!isAuthenticated">
                <i class="fas fa-info-circle me-2"></i>
                <a href="{{ route_to('login.comment', $song->slug) }}" class="alert-link">Login</a> to post a comment.
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
                                <!-- Updated: Use permission-based showing instead of user ID comparison -->
                                <div class="comment-actions" x-show="comment.can_edit || comment.can_delete">
                                    <button @click="editComment(comment)" class="btn btn-sm btn-outline-secondary me-1"
                                        title="Edit comment" x-show="comment.can_edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button @click="deleteComment(comment.id)" class="btn btn-sm btn-outline-danger"
                                        title="Delete comment" x-show="comment.can_delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Comment Text -->
                            <div class="comment-text" x-show="editingCommentId !== comment.id">
                                <p x-text="comment.content" class="mb-2"></p>
                            </div>

                            <!-- Edit Form -->
                            <div class="edit-comment-form" x-show="editingCommentId === comment.id">
                                <form @submit.prevent="updateComment(comment)">
                                    <div class="mb-2">
                                        <textarea x-model="editCommentContent" class="form-control" rows="3"
                                            maxlength="1000" required></textarea>
                                        <small class="text-muted d-block mt-1"
                                            :class="{'text-danger': editCommentContent.length > 950}">
                                            <span x-text="editCommentContent.length"></span>/1000 characters
                                        </small>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-sm btn-primary"
                                            :disabled="!editCommentContent.trim() || editCommentContent.length > 1000">
                                            <i class="fas fa-save me-1"></i>Save
                                        </button>
                                        <button type="button" @click="cancelEdit()" class="btn btn-sm btn-secondary">
                                            <i class="fas fa-times me-1"></i>Cancel
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Reply Button -->
                            <div class="comment-footer" x-show="editingCommentId !== comment.id && isAuthenticated">
                                <button @click="toggleReplyForm(comment.id)"
                                    class="btn btn-sm btn-link text-decoration-none p-0">
                                    <i class="fas fa-reply me-1"></i>Reply
                                </button>
                            </div>
                        </div>

                        <!-- Reply Form -->
                        <div class="reply-form mt-3" x-show="replyingToId === comment.id">
                            <form @submit.prevent="submitReply(comment.id)">
                                <div class="mb-2">
                                    <textarea x-model="replyContent" class="form-control" rows="3"
                                        placeholder="Write a reply..." maxlength="1000" required></textarea>
                                    <small class="text-muted d-block mt-1"
                                        :class="{'text-danger': replyContent.length > 950}">
                                        <span x-text="replyContent.length"></span>/1000 characters
                                    </small>
                                </div>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-sm btn-primary"
                                        :disabled="!replyContent.trim() || replyContent.length > 1000">
                                        <i class="fas fa-reply me-1"></i>Reply
                                    </button>
                                    <button type="button" @click="cancelReply()" class="btn btn-sm btn-secondary">
                                        <i class="fas fa-times me-1"></i>Cancel
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Replies -->
                        <div class="replies mt-3" x-show="comment.replies && comment.replies.length > 0">
                            <template x-for="reply in comment.replies || []" :key="'reply-' + reply.id">
                                <div class="reply-item">
                                    <div class="comment-header">
                                        <img :src="reply.user.image" :alt="reply.user.name" class="comment-avatar">
                                        <div class="comment-meta">
                                            <strong x-text="reply.user.name"></strong>
                                            <small class="text-muted" x-text="reply.created_at"></small>
                                        </div>
                                        <!-- Updated: Use permission-based showing for replies -->
                                        <div class="comment-actions" x-show="reply.can_edit || reply.can_delete">
                                            <button @click="editComment(reply)"
                                                class="btn btn-sm btn-outline-secondary me-1" title="Edit reply"
                                                x-show="reply.can_edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button @click="deleteComment(reply.id)"
                                                class="btn btn-sm btn-outline-danger" title="Delete reply"
                                                x-show="reply.can_delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Reply Text (when not editing) -->
                                    <div class="comment-text" x-show="editingCommentId !== reply.id">
                                        <p x-text="reply.content" class="mb-0"></p>
                                    </div>

                                    <!-- Edit Form for Replies -->
                                    <div class="edit-comment-form mt-2" x-show="editingCommentId === reply.id">
                                        <form @submit.prevent="updateComment(reply)">
                                            <div class="mb-2">
                                                <textarea x-model="editCommentContent" class="form-control" rows="3"
                                                    maxlength="1000" required></textarea>
                                                <small class="text-muted d-block mt-1"
                                                    :class="{'text-danger': editCommentContent.length > 950}">
                                                    <span x-text="editCommentContent.length"></span>/1000 characters
                                                </small>
                                            </div>
                                            <div class="d-flex gap-2">
                                                <button type="submit" class="btn btn-sm btn-primary"
                                                    :disabled="!editCommentContent.trim() || editCommentContent.length > 1000">
                                                    <i class="fas fa-save me-1"></i>Save
                                                </button>
                                                <button type="button" @click="cancelEdit()"
                                                    class="btn btn-sm btn-secondary">
                                                    <i class="fas fa-times me-1"></i>Cancel
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Load More Button -->
            <div class="text-center mt-4" x-show="hasMorePages && !loadingMore">
                <button @click="loadMoreComments()" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-down me-1"></i>
                    Load More Comments
                </button>
            </div>

            <!-- Loading More Indicator -->
            <div class="text-center mt-4" x-show="loadingMore">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2 text-muted">Loading more comments...</p>
            </div>

            <!-- No Comments -->
            <div class="text-center py-5" x-show="comments.length === 0 && !loadingMore">
                <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                <p class="text-muted mb-0">No comments yet. Be the first to share your thoughts!</p>
            </div>
        </div>
    </div>
</section>