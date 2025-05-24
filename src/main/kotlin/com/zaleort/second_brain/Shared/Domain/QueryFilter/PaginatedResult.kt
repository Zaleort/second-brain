package com.zaleort.second_brain.Shared.Domain.QueryFilter

data class PaginatedResult<T>(
    val items: List<T>,
    val total: Long,
    val page: Int,
    val limit: Int,
)
