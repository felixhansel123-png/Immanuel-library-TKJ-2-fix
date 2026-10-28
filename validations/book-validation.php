<?php
require_once __DIR__ . "/../repositories/book-repository.php";
require_once __DIR__ . "/../repositories/category-repository.php";
require_once __DIR__ . "/../repositories/author-repository.php";
function getBookRequest($request)
{
    return [
        'id' => trim(htmlspecialchars($request['id'])),
        'title' => trim(htmlspecialchars($request['title'])),
        'isbn' => trim(htmlspecialchars($request['isbn'])),
        'year' => trim(htmlspecialchars($request['year'])),
        'stock' => trim(htmlspecialchars($request['stock'])),
        'description' => trim(htmlspecialchars($request['description'])),
        'category_id' => trim(htmlspecialchars($request['category_id'])),
        'author_ids' => $request['author_ids'] ?? [],
    ];
}

function validateBook($request, $ignoreBookId = 0)
{
    $errors = [];

    // validate title: required and max 100 char
    if ($request['title'] == "") {
        $errors['title'] = "Title is required";
    } elseif (mb_strlen($request['title']) > 100) {
        $errors['title'] = "Title must be less than 100 characters";
    }


    // validate isbn: required, Istaken?

    if ($request['isbn'] == "") {
        $errors['isbn'] = "ISBN is required";
    } elseif (isIsbnTaken($request['isbn'], $ignoreBookId)) {
        $errors['isbn'] = "ISBN is already taken";
    }
    // validate year: required, isnumber

    if ($request['year'] == "") {
        $errors['year'] = "Year is required";
    } elseif (!is_int(intval($request['year']))) {
        $errors['year'] = "Year must be a number";
    }

    // validate stock: required, isnumber

    if ($request['stock'] == "") {
        $errors['stock'] = "Stock is required";
    } elseif (!is_int(intval($request['stock']))) {
        $errors['stock'] = "Stock must be a number";
    }

    // validate category: required, isExists
    if ($request['category_id'] == "") {
        $errors['category_id'] = "Category is required";
    } elseif (!isCategoryExists($request['category_id'])) {
        $errors['category_id'] = "Invalid category";
    }

    // validate description: required, max 200 character
    if ($request['description'] == "") {
        $errors['description'] = "Description is required";
    } elseif (mb_strlen($request['description']) > 200) {
        $errors['description'] = "Description must be not than 200 characters";
    }

    //validate Authors: required, isExists

    if (count($request['author_ids']) < 1) {
        $errors['author_ids'] = "Author is required";
    } else {
        $authors = getAuthors();
        $validAuthorIds = array_column($authors, 'id');
        foreach ($request['author_ids'] as $authorId) {
            if (!in_array($authorId, $validAuthorIds)) {
                $errors['author_ids'] = "There is an invalid author selected";
            }
        }
    }
    return $errors;

}

?>