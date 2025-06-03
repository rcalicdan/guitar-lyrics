<script>
    function commentManager(songSlug) {
        return {
            songSlug: songSlug,
            comments: [],
            newComment: {
                content: ''
            },
            replyContent: '',
            replyingToId: null,
            submittingComment: false,
            editingCommentId: null,
            editCommentContent: '',
            isAuthenticated: {{ auth()->check() ? 'true' : 'false' }},
            currentUserId: {{ auth()->check() ? auth()->user()->id : 'null' }},
            currentPage: 1,
            hasMorePages: false,
            loadingMore: false,
            totalComments: 0,
            
            init() {
                this.loadComments();
            },

            async loadComments(page = 1) {
                if (page === 1) {
                    this.comments = [];
                    this.currentPage = 1;
                }
                
                this.loadingMore = page > 1;
                
                try {
                    const response = await axios.get(`/api/songs/${this.songSlug}/comments?page=${page}`);
                    
                    if (response.data.success) {
                        const responseData = response.data.data;
                        
                        if (page === 1) {
                            this.comments = responseData.data;
                        } else {
                            this.comments.push(...responseData.data);
                        }
                        
                        this.currentPage = responseData.pagination.current_page;
                        this.hasMorePages = responseData.pagination.has_more_pages;
                        this.totalComments = this.comments.length;
                        
                    } else {
                        this.showNotification(response.data.message || 'Error loading comments', 'error');
                    }
                } catch (error) {
                    console.error('Error loading comments:', error);
                    if (error.response?.status === 404) {
                        this.showNotification('Song not found', 'error');
                    } else {
                        this.showNotification('Error loading comments', 'error');
                    }
                } finally {
                    this.loadingMore = false;
                }
            },

            async loadMoreComments() {
                if (this.hasMorePages && !this.loadingMore) {
                    await this.loadComments(this.currentPage + 1);
                }
            },

            async submitComment() {
                if (!this.validateComment(this.newComment.content)) return;
                
                this.submittingComment = true;
                
                try {
                    const response = await axios.post(`/api/songs/${this.songSlug}/comments`, {
                        content: this.newComment.content
                    }, {
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    
                    if (response.data.success) {
                        // Add new comment to the beginning of the list
                        this.comments.unshift(response.data.data);
                        this.totalComments = this.comments.length;
                        this.newComment.content = '';
                        this.showNotification(response.data.message || 'Comment posted successfully!', 'success');
                    } else {
                        this.showNotification(response.data.message || 'Error posting comment', 'error');
                    }
                } catch (error) {
                    console.error('Error posting comment:', error);
                    this.handleApiError(error, 'Error posting comment');
                } finally {
                    this.submittingComment = false;
                }
            },

            async submitReply(parentId) {
                if (!this.validateComment(this.replyContent)) return;
                
                try {
                    const response = await axios.post(`/api/songs/${this.songSlug}/comments`, {
                        content: this.replyContent,
                        parent_id: parentId
                    }, {
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    
                    if (response.data.success) {
                        const parentComment = this.comments.find(c => c.id === parentId);
                        if (parentComment) {
                            if (!parentComment.replies) {
                                parentComment.replies = [];
                            }
                            parentComment.replies.push(response.data.data);
                        }
                        
                        this.replyContent = '';
                        this.replyingToId = null;
                        this.showNotification(response.data.message || 'Reply posted successfully!', 'success');
                    } else {
                        this.showNotification(response.data.message || 'Error posting reply', 'error');
                    }
                } catch (error) {
                    console.error('Error posting reply:', error);
                    this.handleApiError(error, 'Error posting reply');
                }
            },

            editComment(comment) {
                this.editingCommentId = comment.id;
                this.editCommentContent = comment.content;
            },

            async updateComment(comment) {
                if (!this.validateComment(this.editCommentContent)) return;
                
                try {
                    const response = await axios.patch(`/api/songs/${this.songSlug}/comments/${comment.id}`, {
                        content: this.editCommentContent
                    }, {
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    
                    if (response.data.success) {
                        comment.content = this.editCommentContent;
                        comment.updated_at = new Date().toISOString(); 
                        this.cancelEdit();
                        this.showNotification(response.data.message || 'Comment updated successfully!', 'success');
                    } else {
                        this.showNotification(response.data.message || 'Error updating comment', 'error');
                    }
                } catch (error) {
                    console.error('Error updating comment:', error);
                    this.handleApiError(error, 'Error updating comment');
                }
            },

            async deleteComment(commentId) {
                if (!confirm('Are you sure you want to delete this comment?')) return;
                
                try {
                    const response = await axios.delete(`/api/songs/${this.songSlug}/comments/${commentId}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    
                    if (response.data.success) {
                        this.comments = this.comments.filter(c => {
                            if (c.id === commentId) return false;
                            if (c.replies) {
                                c.replies = c.replies.filter(r => r.id !== commentId);
                            }
                            return true;
                        });
                        
                        this.totalComments = this.comments.length;
                        this.showNotification(response.data.message || 'Comment deleted successfully!', 'success');
                    } else {
                        this.showNotification(response.data.message || 'Error deleting comment', 'error');
                    }
                } catch (error) {
                    console.error('Error deleting comment:', error);
                    this.handleApiError(error, 'Error deleting comment');
                }
            },

            toggleReplyForm(commentId) {
                this.replyingToId = this.replyingToId === commentId ? null : commentId;
                this.replyContent = '';
            },

            cancelReply() {
                this.replyingToId = null;
                this.replyContent = '';
            },

            cancelEdit() {
                this.editingCommentId = null;
                this.editCommentContent = '';
            },

            validateComment(content) {
                if (!content.trim()) {
                    this.showNotification('Comment content is required', 'error');
                    return false;
                }
                
                if (content.length > 1000) {
                    this.showNotification('Comment cannot exceed 1000 characters', 'error');
                    return false;
                }
                
                return true;
            },

            handleApiError(error, defaultMessage) {
                if (error.response) {
                    if (error.response.status === 400 && error.response.data.errors) {
                        const errors = Object.values(error.response.data.errors).flat();
                        this.showNotification(errors.join(', '), 'error');
                    } else if (error.response.status === 404) {
                        this.showNotification('Comment not found or unauthorized', 'error');
                    } else if (error.response.status === 401) {
                        this.showNotification('Please log in to perform this action', 'error');
                    } else {
                        this.showNotification(error.response.data.message || defaultMessage, 'error');
                    }
                } else {
                    this.showNotification(defaultMessage, 'error');
                }
            },

            showNotification(message, type = 'info') {
                const alertClass = type === 'success' ? 'alert-success' : 
                                   type === 'error' ? 'alert-danger' : 'alert-info';
                
                const alertDiv = document.createElement('div');
                alertDiv.className = `alert ${alertClass} alert-dismissible fade show position-fixed`;
                alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; max-width: 400px;';
                alertDiv.innerHTML = `
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                
                document.body.appendChild(alertDiv);
                
                setTimeout(() => {
                    if (alertDiv.parentNode) {
                        alertDiv.remove();
                    }
                }, 5000);
            }
        }
    }
</script>