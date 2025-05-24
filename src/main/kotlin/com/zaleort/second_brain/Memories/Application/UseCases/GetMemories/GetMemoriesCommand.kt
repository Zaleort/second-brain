package com.zaleort.second_brain.Memories.Application.UseCases.GetMemories

data class GetMemoriesCommand(
    var page: Int = 1,
    var limit: Int = 12,
    var orderBy: String = "createdAt",
    var orderDirection: String = "DESC",
    val userId: String,
    var title: String? = null,
    var content: String? = null,
    var tags: List<String>? = null,
    var type: Int? = null,
    var createdAtFrom: String? = null,
    var createdAtTo: String? = null,
)
