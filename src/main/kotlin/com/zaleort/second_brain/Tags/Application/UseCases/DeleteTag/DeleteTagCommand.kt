package com.zaleort.second_brain.Tags.Application.UseCases.DeleteTag

data class DeleteTagCommand(
    val id: String,
    val userId: String,
)