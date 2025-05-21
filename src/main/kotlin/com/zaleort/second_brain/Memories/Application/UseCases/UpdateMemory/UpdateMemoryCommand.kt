package com.zaleort.second_brain.Memories.Application.UseCases.UpdateMemory

data class UpdateMemoryCommand(
    val id: String,
    val userId: String,
    val title: String,
    val content: String,
    val type: Int,
    val tags: List<String>,
)
