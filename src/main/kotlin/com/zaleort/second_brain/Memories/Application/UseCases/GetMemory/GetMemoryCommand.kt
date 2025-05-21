package com.zaleort.second_brain.Memories.Application.UseCases.GetMemory

data class GetMemoryCommand(
    val id: String,
    val userId: String,
)
