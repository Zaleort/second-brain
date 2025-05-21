package com.zaleort.second_brain.Tags.Application.UseCases.GetTag

data class GetTagCommand(
    val id: String,
    val userId: String,
)