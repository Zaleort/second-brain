package com.zaleort.second_brain.Memories.Application.UseCases

import com.zaleort.second_brain.Memories.Domain.Memory.Memory

data class MemoryDTO(
    val id: String,
    val userId: String,
    val title: String,
    val content: String,
    val type: Int,
    val tags: List<Map<String, String?>>,
    val createdAt: String,
    val updatedAt: String?,
) {
    companion object {
        fun fromMemory(memory: Memory): MemoryDTO {
            val tags = memory.tags.map { tag ->
                mapOf(
                    "id" to tag.id,
                    "name" to tag.name,
                    "color" to tag.color,
                )
            }

            return MemoryDTO(
                memory.id.value,
                memory.userId.value,
                memory.title.value,
                memory.content.value,
                memory.type.value,
                tags,
                memory.createdAt.toString(),
                memory.updatedAt?.toString(),
            )
        }
    }
}