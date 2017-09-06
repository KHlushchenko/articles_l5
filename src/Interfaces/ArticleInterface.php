<?php
namespace Vis\Articles\Interfaces;

interface ArticleInterface
{
    /**
     * Returns viewFolder property
     * @return string
     */
    public function getViewFolder(): string;

    /**
     * Returns sortOrder property
     * @return string
     */
    public function getSortOrder(): string;

    /**
     * Returns perPage property
     * @return int
     */
    public function getPerPage(): int;

    /**
     * Returns relationsInCatalog property
     * @return array
     */
    public function getRelationsInCatalog(): array;

    /**
     * Returns relationsInArticle property
     * @return array
     */
    public function getRelationsInArticle(): array;

    /**
     * Scope to retrieve only articles for main page
     * @param $query
     * @return mixed
     */
    public function scopeIsMain($query);

    /**
     * Scope to order articles by field:order signature
     * @param $query
     * @param string $order
     * @return mixed
     */
    public function scopeFilterCustomOrder($query, string $order);

}
