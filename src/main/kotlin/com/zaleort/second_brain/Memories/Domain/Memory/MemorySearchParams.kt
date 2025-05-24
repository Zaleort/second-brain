package com.zaleort.second_brain.Memories.Domain.Memory

data class MemorySearchParams(
    val page: Int = 1,
    val limit: Int = 12,
    val orderBy: String = "createdAt",
    val orderDirection: String = "DESC",
    val userId: String? = null,
    val title: String? = null,
    val content: String? = null,
    val type: Int? = null,
    val tags: List<String>? = null,
    val createdAtFrom: String? = null,
    val createdAtTo: String? = null,
)
