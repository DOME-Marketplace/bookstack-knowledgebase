<?php

namespace BookStack\Entities\Controllers;

use BookStack\Entities\Queries\BookQueries;
use BookStack\Entities\Tools\ExportFormatter;
use BookStack\Http\Controller;
use Throwable;

class BookExportController extends Controller
{
    public function __construct(
        protected BookQueries $queries,
        protected ExportFormatter $exportFormatter,
    ) {
        $this->middleware('can:content-export');
    }

    /**
     * Export a book as a PDF file.
     *
     * @throws Throwable
     */
    public function pdf(string $bookSlug)
    {
        $book = $this->queries->findVisibleBySlug($bookSlug);
        $pdfContent = $this->exportFormatter->bookToPdf($book);

        return $this->download()->directly($pdfContent, $bookSlug . '.pdf');
    }

    /**
     * Export a book as a contained HTML file.
     *
     * @throws Throwable
     */
    public function html(string $bookSlug)
    {
        $book = $this->queries->findVisibleBySlug($bookSlug);
        $htmlContent = $this->exportFormatter->bookToContainedHtml($book);

        return $this->download()->directly($htmlContent, $bookSlug . '.html');
    }

    /**
     * Export a book as a plain text file.
     */
    public function plainText(string $bookSlug)
    {
        $book = $this->queries->findVisibleBySlug($bookSlug);
        $textContent = $this->exportFormatter->bookToPlainText($book);

        return $this->download()->directly($textContent, $bookSlug . '.txt');
    }

    /**
     * Export a book as a markdown file.
     */
    public function markdown(string $bookSlug)
    {
        $book = $this->queries->findVisibleBySlug($bookSlug);
        $textContent = $this->exportFormatter->bookToMarkdown($book);

        return $this->download()->directly($textContent, $bookSlug . '.md');
    }
}
