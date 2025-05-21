package com.zaleort.second_brain.Memories.Application.UseCases.CreateMemory

data class CreateMemoryCommand(
    val userId: String,
    val title: String,
    val content: String,
    val type: Int,
    val tags: List<String>,
)
