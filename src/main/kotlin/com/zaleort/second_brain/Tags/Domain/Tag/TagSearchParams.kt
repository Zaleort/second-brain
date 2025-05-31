package com.zaleort.second_brain.Tags.Domain.Tag

data class TagSearchParams(
    val page: Int = 1,
    val limit: Int = 12,
    val orderBy: String = "name",
    val orderDirection: String = "ASC",
    val userId: String? = null,
    val name: String? = null,
)
