package com.zaleort.second_brain.Tags.Application.UseCases.UpdateTag

data class UpdateTagCommand(
    val id: String,
    val name: String,
    val color: String?,
    val userId: String,
)
