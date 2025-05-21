package com.zaleort.second_brain.Memories.Domain.Memory

import com.zaleort.second_brain.Users.Domain.User.UserId

interface MemoryRepositoryInterface {
    fun findById(id: MemoryId): Memory?
    fun findByUserId(userId: UserId): List<Memory>
    fun save(memory: Memory)
    fun deleteById(id: MemoryId)
    fun findAll(): List<Memory>
}