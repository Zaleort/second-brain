package com.zaleort.second_brain.Tags.Application.UseCases.GetTags

data class GetTagsCommand(
    var page: Int = 1,
    var limit: Int = 12,
    var orderBy: String = "name",
    var orderDirection: String = "DESC",
    val userId: String,
    var name: String? = null,
)