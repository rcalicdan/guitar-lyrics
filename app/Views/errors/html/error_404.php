<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= lang('Errors.pageNotFound') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <style>
        :root {
            --primary-color: #2D3436;
            --accent-color: #6C5CE7;
            --gradient-start: #6C5CE7;
            --gradient-end: #a17fe0;
            --light-gray: #f8f9fa;
            --medium-gray: #6c757d;
            --border-color: #e9ecef;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, var(--light-gray) 0%, #ffffff 100%);
            color: var(--primary-color);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1.6;
        }

        .container {
            max-width: 600px;
            margin: 2rem;
            padding: 3rem 2rem;
            background: #ffffff;
            text-align: center;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--gradient-start), var(--gradient-end));
        }

        .error-code {
            font-size: 8rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
            line-height: 1;
        }

        .error-title {
            font-size: 2rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .error-message {
            font-size: 1.1rem;
            color: var(--medium-gray);
            margin-bottom: 2.5rem;
            max-width: 450px;
            margin-left: auto;
            margin-right: auto;
        }

        .button-group {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.875rem 2rem;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 500;
            font-size: 1rem;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            color: white;
            box-shadow: 0 4px 15px rgba(108, 92, 231, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(108, 92, 231, 0.4);
            text-decoration: none;
            color: white;
        }

        .btn-secondary {
            background: #f8f9fa;
            color: var(--primary-color);
            border: 2px solid var(--border-color);
        }

        .btn-secondary:hover {
            background: #e9ecef;
            transform: translateY(-2px);
            text-decoration: none;
            color: var(--primary-color);
            border-color: var(--accent-color);
        }

        .btn:active {
            transform: translateY(0);
        }

        .icon {
            width: 1.2rem;
            height: 1.2rem;
        }

        .illustration {
            margin: 2rem 0;
            opacity: 0.1;
        }

        .illustration svg {
            width: 200px;
            height: 150px;
            fill: var(--accent-color);
        }

        @media (max-width: 768px) {
            .container {
                margin: 1rem;
                padding: 2rem 1.5rem;
            }
            
            .error-code {
                font-size: 6rem;
            }
            
            .error-title {
                font-size: 1.5rem;
            }
            
            .error-message {
                font-size: 1rem;
            }

            .button-group {
                flex-direction: column;
                align-items: center;
            }

            .btn {
                width: 100%;
                max-width: 250px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="error-code">404</div>
        
        <h1 class="error-title">Page Not Found</h1>
        
        <div class="illustration">
            <svg viewBox="0 0 200 150" xmlns="http://www.w3.org/2000/svg">
                <circle cx="100" cy="75" r="50" fill="currentColor" opacity="0.3"/>
                <path d="M75 60 Q100 45 125 60 Q125 90 100 90 Q75 90 75 60 Z" fill="currentColor" opacity="0.5"/>
                <circle cx="85" cy="65" r="3" fill="white"/>
                <circle cx="115" cy="65" r="3" fill="white"/>
            </svg>
        </div>
        
        <p class="error-message">
            <?php if (ENVIRONMENT !== 'production') : ?>
                <?= nl2br(esc($message)) ?>
            <?php else : ?>
                The page you're looking for doesn't exist. It might have been moved, deleted, or you entered the wrong URL.
            <?php endif; ?>
        </p>
        
        <div class="button-group">
            <a href="javascript:history.back()" class="btn btn-secondary">
                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Go Back
            </a>
            
            <a href="/" class="btn btn-primary">
                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Return Home
            </a>
        </div>
    </div>
</body>
</html>