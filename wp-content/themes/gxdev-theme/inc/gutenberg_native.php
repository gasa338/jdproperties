<?php
// Jedan hook za sve (frontend i editor)
add_action('enqueue_block_assets', function () {
    // CSS koji će se učitati i na frontendu i u editoru
    wp_add_inline_style('wp-block-library', '
        .maxwell-element-button {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 0.5rem !important;
            border-radius: 0.5rem !important;
            background-color: #EA603E !important;
            padding: 0.875rem 1.75rem !important;
            font-size: 0.875rem !important;
            font-weight: 600 !important;
            color: #ffffff !important;
            text-decoration: none !important;
            transition: opacity 0.2s !important;
        }

        .wp-block-button__link {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 0.5rem !important;
            border-radius: 0.5rem !important;
            background-color: #EA603E !important;
            padding: 0.875rem 1.75rem !important;
            font-size: 0.875rem !important;
            font-weight: 600 !important;
            color: #ffffff !important;
            text-decoration: none !important;
            transition: opacity 0.2s !important;
        }
            
        
        .wp-block-button {        
            border-radius: 0.5rem !important;
            background: #EA603E !important;
        }
        
        .wp-block-buttons {
            display: inline-flex !important;
            flex-wrap: wrap !important;
            gap: 0.5rem !important;
            align-items: center !important;
        }

        
        /* Preview stilova u editoru */
        .wp-block-paragraph {
            font-size: 16px !important;
            line-height: 1.5 !important;
            color: #666 !important;
            margin-bottom: 12px;
        }


        /* Modern table styling for Gutenberg block */
        .wp-block-table {
            overflow-x: auto;
            margin: 1.5em 0;
        }

        .wp-block-table table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
            line-height: 1.5;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        /* Header styling */
        .wp-block-table th {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            font-weight: 600;
            padding: 14px 12px;
            text-align: left;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Cell styling */
        .wp-block-table td {
            padding: 12px;
            border: 1px solid #e5e7eb;
            vertical-align: top;
        }

        /* Row hover effect */
        .wp-block-table tbody tr:hover {
            background-color: #f8fafc;
            transition: background-color 0.2s ease;
        }

        /* First column styling (agency names) */
        .wp-block-table td:first-child {
            font-weight: 600;
            color: #1e3c72;
            background-color: #fafcff;
        }

        /* Alternating row colors for better readability */
        .wp-block-table tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .wp-block-table table {
                font-size: 0.8rem;
            }
            
            .wp-block-table th,
            .wp-block-table td {
                padding: 10px 8px;
                min-width: 120px;
            }
            
            /* Make table horizontally scrollable on mobile */
            .wp-block-table {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
        }

        /* Optional: Add subtle border radius to first and last cells */
        .wp-block-table tr:first-child th:first-child {
            border-top-left-radius: 12px;
        }

        .wp-block-table tr:first-child th:last-child {
            border-top-right-radius: 12px;
        }



    /* Kompaktna lista sa kontrolisanim razmacima */
    .wp-block-list {
        margin: 0 0 1rem 0;
        padding-left: 1.2rem;
    }
        
    .wp-block-list li:marker {
        display: flex;
    }
    .wp-block-list li {
        display: flex;
    }
    .wp-block-list .block-editor-rich-text__editable {
        margin-left: 10px;
    }

    .wp-block-list li {
        margin-bottom: 0.35rem;
        line-height: 1.3;
        padding-left: 0.25rem;
    }

    /* Za mobilne uređaje */
    @media (max-width: 768px) {
        .wp-block-list {
            padding-left: 1rem;
        }
        
        .wp-block-list li {
            margin-bottom: 0.5rem;
            line-height: 1.4;
        }
    }

    /** blog post style */
    .wp-block-image {
    margin-bottom: 0.5rem !important;
    padding: 0.5rem;
    border-radius: 0.5rem;
    background-color: hsl(var(--accent) / 0.05);
    }

    .wp-block-image img {
    border-radius: 0.5rem;
    }

/* Za glavnu listu u editoru */
.block-editor-block-list__block.wp-block-list {
  list-style-type: disc !important;
  list-style-position: inside !important;
}

/* Za marker (bullet point) u editoru */
.block-editor-block-list__block.wp-block-list li:marker {
  color: #000 !important;
  padding-left: 0.125rem !important;
}

/* Za stavke liste u editoru */
.block-editor-block-list__block.wp-block-list li {
  margin-bottom: 0.5rem !important;
}

/* Alternativno, ako želite da pokrijete i specifične list item blokove */
.wp-block-list-item {
  margin-bottom: 0.5rem !important;
}

.wp-block-list-item::marker {
  color: hsl(var(--accent)) !important;
  padding-left: 0.125rem !important;
}
    ');
});

// Vaš postojeći kod za modifikaciju HTML-a
add_filter('render_block', function ($block_content, $block) {
    if ($block['blockName'] === 'core/button') {
        $search = 'wp-block-button__link wp-element-button';
        $replace = 'maxwell-element-button inline-flex items-center justify-center gap-2 rounded-lg !bg-accent px-7 py-3.5 text-sm font-semibold text-accent-foreground hover:opacity-90 transition-opacity shadow-lg shadow-accent/20 no-underline';
        $block_content = str_replace($search, $replace, $block_content);
    }

    if ($block['blockName'] === 'core/buttons') {
        $search = 'wp-block-buttons is-layout-flex';
        $replace = 'wp-block-buttons is-layout-flex inline-flex flex-wrap gap-2 mb-4';
        $block_content = str_replace($search, $replace, $block_content);
    }

    return $block_content;
}, 10, 2);
