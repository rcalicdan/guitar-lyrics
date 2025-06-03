<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    function songShow(songId, songSlug) {
        return {
            songId: songId,
            songSlug: songSlug,
            isFavorite: false,
            viewCount: Math.floor(Math.random() * 1000) + 100,
            fontSize: 'medium',
            autoScrolling: false,
            isFullscreen: false,
            showFloatingActions: false,
            showScrollTop: false,
            scrollInterval: null,
            relatedSongs: [],
            
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
            
            init() {
                this.loadRelatedSongs();
                this.setupScrollListeners();
                this.loadUserPreferences();
                this.loadComments();
                
                setTimeout(() => {
                    this.showFloatingActions = true;
                }, 1000);
            },

            async loadComments() {
                try {
                    const response = await axios.get(`/api/songs/${this.songSlug}/comments`);
                    
                    if (response.data.success) {
                        this.comments = response.data.data;
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
                }
            },

            async submitComment() {
                if (!this.newComment.content.trim()) {
                    this.showNotification('Comment content is required', 'error');
                    return;
                }
                
                if (this.newComment.content.length > 1000) {
                    this.showNotification('Comment cannot exceed 1000 characters', 'error');
                    return;
                }
                
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
                        this.comments.unshift(response.data.data);
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
                if (!this.replyContent.trim()) {
                    this.showNotification('Reply content is required', 'error');
                    return;
                }
                
                if (this.replyContent.length > 1000) {
                    this.showNotification('Reply cannot exceed 1000 characters', 'error');
                    return;
                }
                
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
                if (!this.editCommentContent.trim()) {
                    this.showNotification('Comment content is required', 'error');
                    return;
                }
                
                if (this.editCommentContent.length > 1000) {
                    this.showNotification('Comment cannot exceed 1000 characters', 'error');
                    return;
                }
                
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

            handleApiError(error, defaultMessage) {
                if (error.response) {
                    // Handle validation errors
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
                // You can replace this with a proper notification system
                const alertClass = type === 'success' ? 'alert-success' : 
                                   type === 'error' ? 'alert-danger' : 'alert-info';
                
                // Create and show a Bootstrap alert
                const alertDiv = document.createElement('div');
                alertDiv.className = `alert ${alertClass} alert-dismissible fade show position-fixed`;
                alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; max-width: 400px;';
                alertDiv.innerHTML = `
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                
                document.body.appendChild(alertDiv);
                
                // Auto remove after 5 seconds
                setTimeout(() => {
                    if (alertDiv.parentNode) {
                        alertDiv.remove();
                    }
                }, 5000);
            },

            // Rest of the methods remain the same...
            formatNumber(num) {
                if (num >= 1000000) {
                    return (num / 1000000).toFixed(1) + 'M';
                } else if (num >= 1000) {
                    return (num / 1000).toFixed(1) + 'K';
                }
                return num.toString();
            },
            
            loadRelatedSongs() {
                const serverRelatedSongs = @json($relatedSongs);

                this.relatedSongs = serverRelatedSongs.map(song => ({
                    id: song.id,
                    title: song.title,
                    slug: song.slug,
                    artist_name: song.artist ? song.artist.name : 'Unknown Artist',
                    image_path: song.image_path || '/placeholder/no-image.png'
                }));
            },
            
            setupScrollListeners() {
                window.addEventListener('scroll', () => {
                    this.showScrollTop = window.pageYOffset > 300;
                    
                    clearTimeout(this.scrollTimeout);
                    this.scrollTimeout = setTimeout(() => {
                        this.showFloatingActions = true;
                    }, 150);
                });
            },
            
            loadUserPreferences() {
                const savedFontSize = localStorage.getItem('songFontSize');
                if (savedFontSize) {
                    this.fontSize = savedFontSize;
                }
                
                const savedAutoScroll = localStorage.getItem('autoScrolling');
                if (savedAutoScroll) {
                    this.autoScrolling = savedAutoScroll === 'true';
                }
            },
            
            saveUserPreferences() {
                localStorage.setItem('songFontSize', this.fontSize);
                localStorage.setItem('autoScrolling', this.autoScrolling.toString());
            },
            
            changeFontSize(size) {
                this.fontSize = size;
                this.saveUserPreferences();
            },
            
            toggleFavorite() {
                this.isFavorite = !this.isFavorite;
            },
            
            toggleAutoScroll() {
                this.autoScrolling = !this.autoScrolling;
                
                if (this.autoScrolling) {
                    this.startAutoScroll();
                } else {
                    this.stopAutoScroll();
                }
                
                this.saveUserPreferences();
            },
            
            startAutoScroll() {
                this.scrollInterval = setInterval(() => {
                    window.scrollBy(0, 1);
                    
                    if ((window.innerHeight + window.pageYOffset) >= document.body.offsetHeight) {
                        this.stopAutoScroll();
                    }
                }, 50); 
            },
            
            stopAutoScroll() {
                if (this.scrollInterval) {
                    clearInterval(this.scrollInterval);
                    this.scrollInterval = null;
                }
                this.autoScrolling = false;
            },
            
            toggleFullscreen() {
                if (!this.isFullscreen) {
                    if (document.documentElement.requestFullscreen) {
                        document.documentElement.requestFullscreen();
                    }
                } else {
                    if (document.exitFullscreen) {
                        document.exitFullscreen();
                    }
                }
                this.isFullscreen = !this.isFullscreen;
            },
            
            scrollToTop() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            },
            
            destroy() {
                this.stopAutoScroll();
                window.removeEventListener('scroll', this.setupScrollListeners);
            }
        }
    }

    function imageLoader(imagePath) {
    return {
        imageSrc: imagePath,
        imageLoaded: false,
        imageError: false,
        retryCount: 0,
        maxRetries: 3,
        
        init() {
            this.preloadImage();
        },
        
        preloadImage() {
            const img = new Image();
            
            img.onload = () => {
                console.log('Image loaded successfully:', this.imageSrc);
                this.imageLoaded = true;
                this.imageError = false;
            };
            
            img.onerror = () => {
                console.log('Image failed to load:', this.imageSrc, 'Retry:', this.retryCount);
                
                if (this.retryCount < this.maxRetries) {
                    this.retryCount++;
                    // Retry after a short delay
                    setTimeout(() => {
                        this.preloadImage();
                    }, 1000 * this.retryCount); // Exponential backoff
                } else {
                    this.imageError = true;
                    this.imageLoaded = false;
                    this.imageSrc = '/placeholder/no-image.png';
                }
            };
            
            // Add cache busting for problematic images
            const cacheBuster = this.retryCount > 0 ? `?v=${Date.now()}` : '';
            img.src = this.imageSrc + cacheBuster;
        }
    }
}
</script>