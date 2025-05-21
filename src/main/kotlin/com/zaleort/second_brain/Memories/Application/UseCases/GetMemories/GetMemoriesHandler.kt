package com.zaleort.second_brain.Memories.Application.UseCases.GetMemories

import com.zaleort.second_brain.Memories.Application.UseCases.MemoryDTO
import com.zaleort.second_brain.Memories.Domain.Memory.MemoryRepositoryInterface
import com.zaleort.second_brain.Users.Domain.User.UserId
import org.springframework.stereotype.Service

@Service
class GetMemoriesHandler(
    private val memoryRepository: MemoryRepositoryInterface,
) {
    fun execute(command: GetMemoriesCommand): List<MemoryDTO> {
        val memories = memoryRepository.findByUserId(UserId(command.userId))
        return memories.map { MemoryDTO.fromMemory(it)}
    }
}