<?php

namespace App\Domain\Products;

enum ProductStatus: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
    case FLASH_SALE = 'flash_sale';
    case ARCHIVED = 'archived';
}